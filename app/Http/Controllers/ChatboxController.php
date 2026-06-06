<?php

namespace App\Http\Controllers;

use App\Services\ChatboxService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatboxController extends Controller
{
    protected ChatboxService $chatboxService;

    public function __construct(ChatboxService $chatboxService)
    {
        $this->chatboxService = $chatboxService;
    }

    /**
     * API gửi tin nhắn từ Widget Chatbox nổi
     */
    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $userId = Auth::id();
        if (!$userId) {
            return response()->json(['message' => 'Vui lòng đăng nhập để sử dụng chatbox.', 'redirect_url' => null], 401);
        }

        $message = $request->input('message');
        $imageFile = $request->file('image');

        $result = $this->chatboxService->sendMessage($userId, $message, $imageFile);

        return response()->json($result);
    }

    /**
     * Admin cập nhật hạn mức tuần theo vai trò
     */
    public function updateLimit(Request $request)
    {
        if (!Auth::user() || !Auth::user()->isAdmin()) {
            abort(403);
        }

        $request->validate([
            'limit_admin' => 'required|integer|min:1',
            'limit_staff' => 'required|integer|min:1',
            'limit_user'  => 'required|integer|min:1',
        ]);

        $settings = $this->chatboxService->getSettings();
        $settings['weeklyRoleLimits'] = [
            'admin' => (int) $request->input('limit_admin'),
            'staff' => (int) $request->input('limit_staff'),
            'user'  => (int) $request->input('limit_user'),
        ];

        $this->chatboxService->saveSettings($settings);

        return back()->with('success', 'Cập nhật hạn mức token theo vai trò thành công!');
    }

    /**
     * Admin thêm một API Key mới (có xác thực)
     */
    public function addKey(Request $request)
    {
        if (!Auth::user() || !Auth::user()->isAdmin()) {
            abort(403);
        }

        $request->validate([
            'api_key' => 'required|string'
        ]);

        $newKey = trim($request->input('api_key'));

        // Validate API key với Groq
        $isValid = $this->chatboxService->validateKey($newKey);
        if (!$isValid) {
            return back()->with('error', 'API Key không hợp lệ hoặc không thể kết nối xác thực với Groq API!');
        }

        $settings = $this->chatboxService->getSettings();
        $exists = false;
        foreach ($settings['api_keys'] as $ki) {
            $k = is_array($ki) ? $ki['key'] : $ki;
            if ($k === $newKey) {
                $exists = true;
                break;
            }
        }

        if (!$exists) {
            $settings['api_keys'][] = [
                'key' => $newKey,
                'limit_requests' => $isValid['limit_requests'] ?? 0,
                'limit_tokens' => $isValid['limit_tokens'] ?? 0,
                'remaining_requests' => $isValid['remaining_requests'] ?? 0,
                'remaining_tokens' => $isValid['remaining_tokens'] ?? 0,
                'last_used' => null,
                'status' => 'active'
            ];
            $this->chatboxService->saveSettings($settings);
        }

        return back()->with('success', 'Đã thêm và xác minh thành công API Key mới!');
    }

    /**
     * Admin xóa một API Key
     */
    public function deleteKey(Request $request)
    {
        if (!Auth::user() || !Auth::user()->isAdmin()) {
            abort(403);
        }

        $request->validate([
            'api_key' => 'required|string'
        ]);

        $keyToDelete = trim($request->input('api_key'));

        $settings = $this->chatboxService->getSettings();
        $settings['api_keys'] = array_filter($settings['api_keys'], function ($ki) use ($keyToDelete) {
            $k = is_array($ki) ? $ki['key'] : $ki;
            return $k !== $keyToDelete;
        });

        // Re-index array
        $settings['api_keys'] = array_values($settings['api_keys']);

        $this->chatboxService->saveSettings($settings);

        return back()->with('success', 'Đã xóa API Key thành công!');
    }
}
