<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class ChatboxService
{
    protected string $filePath;

    public function __construct()
    {
        $this->filePath = storage_path('app/database.json');
        $this->initializeSettings();
    }

    /**
     * Khởi tạo file cấu hình mặc định nếu chưa tồn tại
     */
    protected function initializeSettings(): void
    {
        if (!file_exists($this->filePath)) {
            $dir = dirname($this->filePath);
            if (!is_dir($dir)) {
                mkdir($dir, 0755, true);
            }

            $defaultKeys = [];
            $envKeys = env('GROQ_API_KEYS');
            if (!empty($envKeys)) {
                $rawKeys = array_filter(array_map('trim', explode(',', $envKeys)));
                foreach ($rawKeys as $rawKey) {
                    $defaultKeys[] = [
                        'key' => $rawKey,
                        'limit_requests' => 0,
                        'limit_tokens' => 0,
                        'remaining_requests' => 0,
                        'remaining_tokens' => 0,
                        'last_used' => null,
                        'status' => 'active'
                    ];
                }
            }

            $initialData = [
                'weeklyTokenLimit' => 50000,
                'weeklyRoleLimits' => [
                    'admin' => 200000,
                    'staff' => 100000,
                    'user' => 50000
                ],
                'api_keys' => $defaultKeys,
                'userTokenUsage' => []
            ];

            file_put_contents($this->filePath, json_encode($initialData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        }
    }

    /**
     * Lấy toàn bộ cấu hình từ database.json và migrate nếu cần
     */
    public function getSettings(): array
    {
        $this->initializeSettings();
        $content = file_get_contents($this->filePath);
        $settings = json_decode($content, true) ?: [];

        // Đảm bảo có weeklyRoleLimits
        if (!isset($settings['weeklyRoleLimits'])) {
            $settings['weeklyRoleLimits'] = [
                'admin' => 200000,
                'staff' => 100000,
                'user' => 50000
            ];
        }

        // Migrate api_keys từ string[] sang object[] nếu cần
        if (isset($settings['api_keys'])) {
            $migrated = [];
            foreach ($settings['api_keys'] as $keyItem) {
                if (is_string($keyItem)) {
                    $migrated[] = [
                        'key' => $keyItem,
                        'limit_requests' => 0,
                        'limit_tokens' => 0,
                        'remaining_requests' => 0,
                        'remaining_tokens' => 0,
                        'last_used' => null,
                        'status' => 'active'
                    ];
                } else {
                    $migrated[] = $keyItem;
                }
            }
            $settings['api_keys'] = $migrated;
        }

        return $settings;
    }

    /**
     * Lưu cấu hình vào database.json
     */
    public function saveSettings(array $data): bool
    {
        $content = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        return file_put_contents($this->filePath, $content) !== false;
    }

    /**
     * Lấy lượng token còn lại của user trong tuần này dựa theo role của họ
     */
    public function getRemainingTokens(string $userId): int
    {
        $settings = $this->getSettings();
        
        $userModel = \App\Models\User::find($userId);
        $role = 'user';
        if ($userModel) {
            if ($userModel->hasRole('admin')) {
                $role = 'admin';
            } elseif ($userModel->hasRole('staff')) {
                $role = 'staff';
            }
        }
        
        $roleLimits = $settings['weeklyRoleLimits'] ?? [
            'admin' => 200000,
            'staff' => 100000,
            'user' => 50000
        ];
        
        $limit = $roleLimits[$role] ?? ($settings['weeklyTokenLimit'] ?? 50000);
        
        $sevenDaysAgo = time() - (7 * 24 * 60 * 60);
        $usedTokens = 0;

        foreach ($settings['userTokenUsage'] as $usage) {
            if (($usage['userId'] ?? '') === $userId && ($usage['timestamp'] ?? 0) >= $sevenDaysAgo) {
                $usedTokens += ($usage['tokens'] ?? 0);
            }
        }

        return max(0, $limit - $usedTokens);
    }

    /**
     * Ghi nhận lượt sử dụng token của user
     */
    protected function logTokenUsage(string $userId, int $tokens): void
    {
        $settings = $this->getSettings();
        $settings['userTokenUsage'][] = [
            'userId' => $userId,
            'tokens' => $tokens,
            'timestamp' => time()
        ];
        
        // Dọn dẹp các log cũ hơn 30 ngày để giảm dung lượng file
        $thirtyDaysAgo = time() - (30 * 24 * 60 * 60);
        $settings['userTokenUsage'] = array_filter($settings['userTokenUsage'], function ($usage) use ($thirtyDaysAgo) {
            return ($usage['timestamp'] ?? 0) >= $thirtyDaysAgo;
        });

        $settings['userTokenUsage'] = array_values($settings['userTokenUsage']);
        $this->saveSettings($settings);
    }

    /**
     * Xác thực API key và lấy thông tin rate limit ban đầu
     */
    public function validateKey(string $key): array|bool
    {
        try {
            $response = Http::withToken($key)
                ->timeout(5)
                ->post('https://api.groq.com/openai/v1/chat/completions', [
                    'model' => 'meta-llama/llama-4-scout-17b-16e-instruct',
                    'messages' => [
                        ['role' => 'user', 'content' => 'ping']
                    ],
                    'max_tokens' => 5
                ]);

            if ($response->successful()) {
                return [
                    'limit_requests' => (int)$response->header('x-ratelimit-limit-requests', 0),
                    'limit_tokens' => (int)$response->header('x-ratelimit-limit-tokens', 0),
                    'remaining_requests' => (int)$response->header('x-ratelimit-remaining-requests', 0),
                    'remaining_tokens' => (int)$response->header('x-ratelimit-remaining-tokens', 0),
                ];
            }
            return false;
        } catch (\Exception $e) {
            Log::error("Groq key validation failed: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Gửi tin nhắn và nhận phản hồi từ AI
     */
    public function sendMessage(string $userId, string $message, $imageFile = null): array
    {
        $remaining = $this->getRemainingTokens($userId);
        if ($remaining <= 0) {
            return [
                'message' => 'Bạn đã sử dụng hết hạn mức token cho phép trong tuần này. Vui lòng liên hệ Admin để nâng cấp hạn mức.',
                'redirect_url' => null
            ];
        }

        $settings = $this->getSettings();
        $keys = $settings['api_keys'] ?? [];

        if (empty($keys)) {
            // Kiểm tra env dự phòng
            $envKeys = env('GROQ_API_KEYS');
            if (!empty($envKeys)) {
                $rawKeys = array_filter(array_map('trim', explode(',', $envKeys)));
                foreach ($rawKeys as $rawKey) {
                    $keys[] = [
                        'key' => $rawKey,
                        'limit_requests' => 0,
                        'limit_tokens' => 0,
                        'remaining_requests' => 0,
                        'remaining_tokens' => 0,
                        'last_used' => null,
                        'status' => 'active'
                    ];
                }
            }
        }

        if (empty($keys)) {
            return [
                'message' => 'Hệ thống chưa được cấu hình API Key cho Chatbox AI. Vui lòng liên hệ Admin.',
                'redirect_url' => null
            ];
        }

        // Cơ chế luân chuyển Round-Robin
        $index = Cache::get('groq_key_index', 0);
        $keyItem = $keys[$index % count($keys)];
        $key = is_array($keyItem) ? $keyItem['key'] : $keyItem;
        Cache::put('groq_key_index', $index + 1, 3600);

        // System Prompt định nghĩa vai trò, lọc lạc đề và bảo mật phân quyền theo role
        $userModel = \App\Models\User::find($userId);
        $isAdmin = $userModel ? $userModel->isAdmin() : false;
        $isStaff = $userModel ? $userModel->isStaff() : false;

        // Lấy danh sách thú cưng đang sẵn sàng nhận nuôi để làm ngữ cảnh thực tế cho AI
        $availablePets = \App\Models\Pet::where('Trang_thai', 'san_sang')->get(['Ma_thu_cung', 'Ten', 'Loai', 'Giong', 'Gioi_tinh', 'Nhom_tuoi', 'Can_nang']);
        $petsListStr = "";
        foreach ($availablePets as $idx => $p) {
            $loai = $p->Loai === 'cho' ? 'Chó' : ($p->Loai === 'meo' ? 'Mèo' : 'Khác');
            $petsListStr .= ($idx + 1) . ". Bé {$p->Ten}: Giống {$p->Giong} ({$loai}), Giới tính {$p->Gioi_tinh}, Nhóm tuổi: {$p->Nhom_tuoi}, Cân nặng: {$p->Can_nang}kg, ID: {$p->Ma_thu_cung}\n";
        }

        $systemPrompt = "Bạn là Trợ lý ảo hỗ trợ thông minh của trạm cứu hộ động vật PETJAM.\n";
        $systemPrompt .= "Nhiệm vụ của bạn là tư vấn thông tin nhận nuôi, cứu hộ thú cưng và hỗ trợ người dùng chuyển hướng trang trong hệ thống.\n\n";

        if ($userModel) {
            $personalInfo = "THÔNG TIN CÁ NHÂN CỦA KHÁCH HÀNG ĐANG CHAT (DÙNG ĐỂ XƯNG HÔ VÀ TRẢ LỜI NẾU HỌ HỎI VỀ BẢN THÂN):\n";
            $personalInfo .= "- Họ và tên: " . ($userModel->Ho_ten ?? 'Chưa cập nhật') . "\n";
            $personalInfo .= "- Số điện thoại: " . ($userModel->So_dien_thoai ?? 'Chưa cập nhật') . "\n";
            $personalInfo .= "- Địa chỉ: " . ($userModel->Dia_chi ?? 'Chưa cập nhật') . "\n";
            
            // Đơn nhận nuôi và thú cưng đã nhận
            $userApplications = \App\Models\AdoptionApplication::where('Ma_nguoi_dung', $userId)->with('thuCung')->get();
            if ($userApplications->isEmpty()) {
                $personalInfo .= "- Lịch sử nhận nuôi: Khách hàng chưa có đơn đăng ký nhận nuôi nào.\n";
            } else {
                $personalInfo .= "- Lịch sử Đơn đăng ký nhận nuôi của khách:\n";
                foreach ($userApplications as $app) {
                    $petName = $app->thuCung ? $app->thuCung->Ten : 'Không rõ';
                    $statusLabel = $app->trang_thai_label;
                    $personalInfo .= "  + Đơn nhận nuôi bé {$petName} (Trạng thái: {$statusLabel}).\n";
                    
                    // Lịch phỏng vấn
                    $schedule = \App\Models\InterviewSchedule::where('Ma_don', $app->Ma_don)->first();
                    if ($schedule) {
                        $time = $schedule->Thoi_gian_du_kien ? \Carbon\Carbon::parse($schedule->Thoi_gian_du_kien)->format('H:i d/m/Y') : 'Chưa xếp lịch';
                        $statusText = match($schedule->Trang_thai) {
                            'da_len_lich' => 'Đã lên lịch',
                            'da_hoan_thanh' => 'Đã hoàn thành',
                            'da_huy' => 'Đã hủy',
                            default => $schedule->Trang_thai
                        };
                        $personalInfo .= "    -> Lịch phỏng vấn: {$time} - Trạng thái PV: {$statusText}.\n";
                    }
                }
            }

            // Ủng hộ
            $userDonations = \App\Models\Donation::where('Ma_nguoi_dung', $userId)->where('Trang_thai', 'success')->get();
            if ($userDonations->isNotEmpty()) {
                $totalDonated = $userDonations->sum('So_tien');
                $totalDonatedFormatted = number_format($totalDonated, 0, ',', '.') . ' VNĐ';
                $personalInfo .= "- Lịch sử quyên góp: Khách hàng đã đóng góp tổng cộng {$totalDonatedFormatted} qua " . $userDonations->count() . " lần giao dịch thành công.\n";
            } else {
                $personalInfo .= "- Lịch sử quyên góp: Khách chưa có giao dịch ủng hộ thành công nào.\n";
            }
            
            $systemPrompt .= $personalInfo . "\n";
        }

        if ($isAdmin || $isStaff) {
            $pendingAdoptionsCount = \App\Models\AdoptionApplication::where('Trang_thai', 'cho_duyet')->count();
            $pendingInterviewsCount = \App\Models\InterviewSchedule::whereIn('Trang_thai', ['cho_phong_van'])->count();
            $systemPrompt .= "THÔNG TIN QUẢN TRỊ NỘI BỘ (CHỈ DÀNH CHO BẠN BIẾT ĐỂ BÁO CÁO ADMIN):\n";
            $systemPrompt .= "- Số lượng Đơn nhận nuôi đang chờ duyệt: {$pendingAdoptionsCount} đơn.\n";
            $systemPrompt .= "- Số lượng Lịch phỏng vấn sắp tới (chờ phỏng vấn): {$pendingInterviewsCount} lịch.\n";
            $systemPrompt .= "Nếu Quản trị viên hỏi về tình hình đơn hoặc lịch phỏng vấn, hãy dùng số liệu trên để báo cáo nhanh.\n\n";
        }

        // Thêm ngữ cảnh danh sách thú cưng thực tế
        $systemPrompt .= "DANH SÁCH THÚ CƯNG THỰC TẾ ĐANG CÓ TẠI TRẠM (CỬA HÀNG):\n";
        $systemPrompt .= "Dưới đây là các bé thú cưng thực tế đang có mặt tại cửa hàng/trạm cứu hộ. Bạn TUYỆT ĐỐI CHỈ ĐƯỢC đánh giá, đề xuất hoặc giới thiệu các bé trong danh sách này khi người dùng nhờ gợi ý/tư vấn thú cưng phù hợp. KHÔNG ĐƯỢC tự bịa ra bất kỳ bé nào khác không có trong danh sách dưới đây:\n";
        $systemPrompt .= empty($petsListStr) ? "(Hiện tại không có bé thú cưng nào sẵn sàng)\n\n" : $petsListStr . "\n";

        $systemPrompt .= "QUY TẮC ĐIỀU HƯỚNG VÀ LIÊN KẾT ĐẾN CHI TIẾT THÚ CƯNG:\n";
        $systemPrompt .= "Khi bạn giới thiệu hoặc đề xuất bất kỳ bé thú cưng nào từ danh sách thực tế trên, bạn PHẢI đính kèm đường link xem chi tiết của bé đó sử dụng định dạng relative link markdown: `[Xem chi tiết bé <Tên>](/nhan-nuoi/<Mã_ID_thú_cưng>)`. Ví dụ: `[Xem chi tiết bé Corgi Cam](/nhan-nuoi/c3f5edad-de44-4bf6-a8c7-a46600789b37)`.\n";
        $systemPrompt .= "Nếu người dùng muốn xem chi tiết hoặc chuyển trang xem chi tiết của bé thú cưng nào, hãy chèn thêm thẻ điều hướng ở cuối câu trả lời dạng: `[REDIRECT:/nhan-nuoi/<Mã_ID_thú_cưng>]`. Ví dụ: `[REDIRECT:/nhan-nuoi/c3f5edad-de44-4bf6-a8c7-a46600789b37]`.\n\n";

        // Quy tắc lọc lạc đề
        $systemPrompt .= "QUY TẮC PHẠM VI CHỦ ĐỀ (BẮT BUỘC):\n";
        $systemPrompt .= "Bạn chỉ được trả lời các câu hỏi liên quan đến cứu hộ động vật, nhận nuôi thú cưng, quyên góp ủng hộ, hoạt động của trạm PETJAM và các chức năng của website PETJAM. ";
        $systemPrompt .= "LƯU Ý QUAN TRỌNG: Các câu hỏi về lịch phỏng vấn cá nhân, tiến độ đơn nhận nuôi, thông tin tài khoản và lịch sử ủng hộ của khách hàng HOÀN TOÀN HỢP LỆ. Bạn PHẢI dùng thông tin cá nhân đã được cung cấp ở trên để trả lời họ trực tiếp thay vì từ chối.\n";
        $systemPrompt .= "Nếu người dùng hỏi câu hỏi hoàn toàn không liên quan đến các chủ đề trên (ví dụ: thời tiết, công nghệ, toán học, lập trình, viết code, danh nhân, kiến thức ngoài lề...), bạn TUYỆT ĐỐI KHÔNG được trả lời mà phải từ chối một cách lịch sự, thân thiện. Ví dụ: 'Tôi là trợ lý ảo của PETJAM, tôi chỉ có thể hỗ trợ các thông tin liên quan đến cứu hộ, nhận nuôi hoặc gây quỹ ủng hộ thú cưng.'\n";
        $systemPrompt .= "LƯU Ý ĐẶC BIỆT: Việc người dùng tải lên ảnh chân dung của họ hoặc bạn bè để nhờ tư vấn loại thú cưng (chó, mèo) phù hợp với tính cách/phong thái của họ là HOÀN TOÀN HỢP LỆ và thuộc phạm vi tư vấn nhận nuôi. Bạn tuyệt đối không được từ chối hoặc coi yêu cầu này là lạc đề!\n\n";

        // Quy tắc chống nội dung độc hại, nói bậy (Safety & Moderation)
        $systemPrompt .= "QUY TẮC KIỂM DUYỆT (SAFETY & MODERATION - BẮT BUỘC):\n";
        $systemPrompt .= "Nếu phát hiện người dùng sử dụng từ ngữ tục tĩu, chửi thề, quấy rối, xúc phạm hoặc có nội dung không lành mạnh, bạn TUYỆT ĐỐI KHÔNG trả lời vào trọng tâm câu hỏi mà phải từ chối phục vụ ngay lập tức, và nhắc nhở họ giữ thái độ lịch sự, văn minh.\n\n";

        // Quy tắc phân tích ảnh (Vision)
        $systemPrompt .= "QUY TẮC PHÂN TÍCH HÌNH ẢNH (VISION):\n";
        $systemPrompt .= "Khi người dùng tải lên hình ảnh, bạn hãy thực hiện:\n";
        $systemPrompt .= "1. Nếu là ảnh một thú cưng (chó, mèo,... đi lạc hoặc ở nhà): Nhận diện loài (chó/mèo/khác), giống loài, màu sắc lông, đặc điểm ngoại hình, biểu cảm và phán đoán độ tuổi/sức khỏe sơ bộ. Đưa ra lời khuyên chăm sóc phù hợp nếu là thú cưng ở nhà hoặc hướng dẫn cứu hộ/nhận nuôi nếu là thú cưng đi lạc và gợi ý xem danh sách nhận nuôi [REDIRECT:/nhan-nuoi].\n";
        $systemPrompt .= "2. Nếu là ảnh chân dung một người (chính người dùng): Hãy phân tích nhanh các đặc điểm phong thái, bối cảnh trong hình (ví dụ: năng động, điềm đạm, thích vận động, nhẹ nhàng...). Bạn BẮT BUỘC phải đề xuất cụ thể ít nhất 1-2 bé thú cưng thực tế đang có tại trạm/cửa hàng (xem danh sách phía trên) phù hợp nhất với phong thái của họ kèm theo liên kết xem chi tiết của bé đó sử dụng định dạng relative link markdown: `[Xem chi tiết bé <Tên>](/nhan-nuoi/<Mã_ID_thú_cưng>)`. Bạn TUYỆT ĐỐI KHÔNG được tự bịa ra giống/tên thú cưng không có trong danh sách trên.\n\n";

        // Quy tắc từ chối điền đơn
        $systemPrompt .= "QUY TẮC TỪ CHỐI ĐIỀN ĐƠN (QUAN TRỌNG):\n";
        $systemPrompt .= "Bạn TUYỆT ĐỐI KHÔNG có chức năng, quyền hạn hoặc công cụ để điền đơn đăng ký nhận nuôi hộ người dùng, không tự đăng ký lịch phỏng vấn hay tự thay đổi thông tin hồ sơ của họ trực tiếp từ cuộc chat. Nếu người dùng yêu cầu điền đơn hay đăng ký hộ, bạn phải từ chối một cách khéo léo và lịch sự, giải thích rằng họ cần tự tay thực hiện trên trang web để đảm bảo tính xác thực, và cung cấp nút/đường dẫn hướng dẫn họ tự điền đơn (ví dụ: gợi ý họ đi đến trang danh sách nhận nuôi [REDIRECT:/nhan-nuoi] để chọn bé thú cưng cụ thể rồi click nút Đăng Ký trên trang chi tiết).\n\n";

        $systemPrompt .= "QUY TẮC SỬ DỤNG LINK TRONG CHAT:\n";
        $systemPrompt .= "Khi bạn chèn các liên kết (hyperlinks) dạng markdown vào văn bản tư vấn, bạn TUYỆT ĐỐI KHÔNG được sử dụng tên miền đầy đủ (ví dụ: không dùng `https://petjam.vn/nhan-nuoi`). Bạn PHẢI sử dụng đường dẫn tương đối (ví dụ: `[Danh sách nhận nuôi](/nhan-nuoi)` hoặc `[Lịch sử đơn nhận nuôi](/tai-khoan/lich-su-nhan-nuoi)`). Điều này rất quan trọng để liên kết hoạt động chính xác trên môi trường localhost.\n\n";

        // Quy tắc định tuyến và phân quyền điều hướng
        $systemPrompt .= "CÁC ĐƯỜNG DẪN TRANG CHÍNH THỨC TRONG HỆ THỐNG PETJAM:\n";
        $systemPrompt .= "- Xem danh sách thú cưng: /nhan-nuoi\n";
        $systemPrompt .= "- Xem chi tiết và đăng ký nhận nuôi thú cưng cụ thể: /nhan-nuoi/{id} hoặc /nhan-nuoi/{id}/dang-ky\n";
        $systemPrompt .= "- Xem tiến trình duyệt đơn, kết quả đăng ký, hoặc xếp lịch phỏng vấn: /tai-khoan/lich-su-nhan-nuoi\n";
        $systemPrompt .= "- Sửa thông tin tài khoản cá nhân: /profile\n";
        $systemPrompt .= "- Xem các chiến dịch ủng hộ/gây quỹ: /ung-ho\n";
        $systemPrompt .= "- Thực hiện quyên góp ủng hộ: /ung-ho/thuc-hien\n\n";

        if ($isAdmin || $isStaff) {
            $systemPrompt .= "Vì bạn đang trò chuyện với Quản trị viên (ADMIN/STAFF), bạn có quyền cung cấp thông tin và điều hướng đến các trang quản lý sau:\n";
            $systemPrompt .= "- Quản lý thú cưng (Thêm/Sửa/Xóa): /quan-tri/thu-cung\n";
            $systemPrompt .= "- Xem và quản lý các đơn đăng ký nhận nuôi thú cưng: /quan-tri/don-nhan-nuoi\n";
            $systemPrompt .= "- Quản lý lịch phỏng vấn: /quan-tri/lich-phong-van\n";
            $systemPrompt .= "- Quản lý chiến dịch gây quỹ: /quan-tri/chien-dich-ung-ho\n";
            $systemPrompt .= "- Xem danh sách các giao dịch quyên góp của nhà hảo tâm: /quan-tri/ung-ho\n";
            $systemPrompt .= "- Quản lý tài khoản người dùng: /quan-tri/nguoi-dung\n";
            $systemPrompt .= "- Cấu hình cài đặt chung của hệ thống: /quan-tri/cai-dat#general hoặc /quan-tri/cai-dat\n";
            $systemPrompt .= "- Cấu hình Email hệ thống: /quan-tri/cai-dat#email\n";
            $systemPrompt .= "- Cấu hình Thanh toán hệ thống (VNPAY): /quan-tri/cai-dat#payment\n";
            $systemPrompt .= "- Cấu hình Thông báo hệ thống: /quan-tri/cai-dat#notification\n";
            $systemPrompt .= "- Quản lý Phân quyền (Roles & Permissions): /quan-tri/cai-dat#roles\n";
            $systemPrompt .= "- Cấu hình Sao lưu & Phục hồi hệ thống: /quan-tri/cai-dat#backup\n";
            $systemPrompt .= "- Cấu hình Chatbox AI (quản lý Groq API Keys & token limit): /quan-tri/cai-dat#chatbox\n";
            $systemPrompt .= "- Nhật ký hoạt động hệ thống (System Logs): /quan-tri/cai-dat#logs\n\n";
        } else {
            $systemPrompt .= "QUY TẮC BẢO MẬT VAI TRÒ (BẮT BUỘC):\n";
            $systemPrompt .= "Người dùng này là khách hàng bình thường, KHÔNG phải Admin hay Staff. Bạn TUYỆT ĐỐI KHÔNG được tiết lộ bất kỳ thông tin nào về các trang quản lý admin (bắt đầu bằng `/quan-tri/`) hay hướng dẫn các thao tác quản trị cho họ. Không bao giờ được chèn thẻ [REDIRECT] hướng đến các đường dẫn `/quan-tri/...` đối với người dùng này.\n\n";
        }

        $systemPrompt .= "QUY TẮC ĐIỀU HƯỚNG:\n";
        $systemPrompt .= "Nếu người dùng muốn chuyển trang, xem, hoặc thực hiện hành động liên quan tới một trang cụ thể mà vai trò của họ được phép truy cập, hãy trả lời một câu tư vấn ngắn gọn và chèn thẻ `[REDIRECT:<đường_dẫn>]` vào CUỐI CÙNG của câu trả lời. \n";
        $systemPrompt .= "Ví dụ: 'Dưới đây là danh sách các bé thú cưng đang chờ được nhận nuôi: [REDIRECT:/nhan-nuoi]'.\n";
        $systemPrompt .= "Không được tự chế đường dẫn không có trong danh sách trên. Không được chèn thẻ REDIRECT nếu người dùng không yêu cầu hoặc hỏi han mang tính tư vấn thông thường.\n\n";
        $systemPrompt .= "Hãy trả lời một cách lịch sự, thân thiện, súc tích bằng Tiếng Việt.";

        // Chuẩn bị tin nhắn gửi tới Groq
        $messages = [
            ['role' => 'system', 'content' => $systemPrompt]
        ];

        if ($imageFile) {
            try {
                $base64 = base64_encode(file_get_contents($imageFile->getRealPath()));
                $mimeType = $imageFile->getClientMimeType();
                $imageUrl = "data:$mimeType;base64,$base64";

                $messages[] = [
                    'role' => 'user',
                    'content' => [
                        ['type' => 'text', 'text' => $message],
                        ['type' => 'image_url', 'image_url' => ['url' => $imageUrl]]
                    ]
                ];
            } catch (\Exception $e) {
                Log::error("Failed to process image upload: " . $e->getMessage());
                return [
                    'message' => 'Lỗi xử lý file ảnh đính kèm. Vui lòng thử lại.',
                    'redirect_url' => null
                ];
            }
        } else {
            $messages[] = [
                'role' => 'user',
                'content' => $message
            ];
        }

        try {
            // Gọi Groq API
            $response = Http::withToken($key)
                ->timeout(30)
                ->post('https://api.groq.com/openai/v1/chat/completions', [
                    'model' => 'meta-llama/llama-4-scout-17b-16e-instruct',
                    'messages' => $messages,
                    'max_tokens' => 1024,
                    'temperature' => 0.7
                ]);

            if (!$response->successful()) {
                Log::error("Groq API response error: " . $response->body());
                
                // Cập nhật trạng thái API Key sang Lỗi
                $settings = $this->getSettings();
                foreach ($settings['api_keys'] as &$ki) {
                    if (is_array($ki) && $ki['key'] === $key) {
                        $ki['status'] = 'error';
                        $ki['last_used'] = time();
                        break;
                    }
                }
                $this->saveSettings($settings);

                return [
                    'message' => 'Chatbot tạm thời gặp sự cố khi kết nối máy chủ AI. Vui lòng thử lại sau.',
                    'redirect_url' => null
                ];
            }

            $result = $response->json();
            $responseText = $result['choices'][0]['message']['content'] ?? '';
            
            // Ghi nhận lượng token đã tiêu thụ
            $usage = $result['usage'] ?? [];
            $totalTokens = ($usage['prompt_tokens'] ?? 0) + ($usage['completion_tokens'] ?? 0);
            if ($totalTokens > 0) {
                $this->logTokenUsage($userId, $totalTokens);
            }

            // Trích xuất ratelimit header từ Groq để cập nhật siêu dữ liệu key
            $limitRequests = (int)$response->header('x-ratelimit-limit-requests', 0);
            $limitTokens = (int)$response->header('x-ratelimit-limit-tokens', 0);
            $remainingRequests = (int)$response->header('x-ratelimit-remaining-requests', 0);
            $remainingTokens = (int)$response->header('x-ratelimit-remaining-tokens', 0);

            $settings = $this->getSettings();
            foreach ($settings['api_keys'] as &$ki) {
                if (is_array($ki) && $ki['key'] === $key) {
                    $ki['limit_requests'] = $limitRequests;
                    $ki['limit_tokens'] = $limitTokens;
                    $ki['remaining_requests'] = $remainingRequests;
                    $ki['remaining_tokens'] = $remainingTokens;
                    $ki['last_used'] = time();
                    $ki['status'] = 'active';
                    break;
                }
            }
            $this->saveSettings($settings);

            // Phân tích xem có thẻ [REDIRECT:<url>] hay không
            $redirectUrl = null;
            if (preg_match('/\[REDIRECT:(.*?)\]/', $responseText, $matches)) {
                $redirectUrl = trim($matches[1]);
                $responseText = str_replace($matches[0], '', $responseText);
            }

            return [
                'message' => trim($responseText),
                'redirect_url' => $redirectUrl
            ];

        } catch (\Exception $e) {
            Log::error("Failed to connect to Groq API: " . $e->getMessage());
            return [
                'message' => 'Không thể kết nối đến máy chủ AI. Vui lòng kiểm tra lại kết nối mạng.',
                'redirect_url' => null
            ];
        }
    }
}
