<?php

namespace App\Services;

use Cloudinary\Cloudinary;
use Cloudinary\Configuration\Configuration;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;

class CloudinaryService
{
    protected ?Cloudinary $cloudinary = null;
    protected bool $isConfigured = false;

    public function __construct()
    {
        try {
            $cloudName = config('services.cloudinary.cloud_name');
            $apiKey = config('services.cloudinary.api_key');
            $apiSecret = config('services.cloudinary.api_secret');

            if (empty($cloudName) || empty($apiKey) || empty($apiSecret)) {
                Log::warning('Cloudinary credentials are not fully configured. Cloudinary uploads will be disabled, using local fallback.');
                $this->isConfigured = false;
                return;
            }

            Configuration::instance([
                'cloud' => [
                    'cloud_name' => $cloudName,
                    'api_key'    => $apiKey,
                    'api_secret' => $apiSecret,
                ],
                'url' => [
                    'secure' => true,
                ],
            ]);

            $this->cloudinary = new Cloudinary();
            $this->isConfigured = true;
        } catch (\Exception $e) {
            Log::error('Cloudinary initialization failed: ' . $e->getMessage());
            $this->isConfigured = false;
        }
    }

    /**
     * Upload ảnh lên Cloudinary hoặc lưu cục bộ nếu chưa cấu hình
     * @return array{url: string, public_id: string}|null
     */
    public function uploadImage(UploadedFile $file, string $folder = 'petjam/pets'): ?array
    {
        if (!$this->isConfigured || !$this->cloudinary) {
            // Local fallback
            try {
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $targetDir = public_path('uploads/' . $folder);
                if (!is_dir($targetDir)) {
                    mkdir($targetDir, 0755, true);
                }
                $file->move($targetDir, $filename);
                $url = asset('uploads/' . $folder . '/' . $filename);
                
                return [
                    'url'       => $url,
                    'public_id' => 'local::' . $folder . '/' . $filename,
                ];
            } catch (\Exception $e) {
                Log::error('Local fallback upload failed: ' . $e->getMessage());
                return null;
            }
        }

        try {
            $result = $this->cloudinary->uploadApi()->upload(
                $file->getRealPath(),
                [
                    'folder'          => $folder,
                    'transformation'  => [
                        ['width' => 1200, 'height' => 900, 'crop' => 'limit', 'quality' => 'auto', 'fetch_format' => 'auto'],
                    ],
                ]
            );

            return [
                'url'       => $result['secure_url'],
                'public_id' => $result['public_id'],
            ];
        } catch (\Exception $e) {
            Log::error('Cloudinary upload failed: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Xóa ảnh khỏi Cloudinary hoặc thư mục local theo public_id
     */
    public function deleteImage(string $publicId): bool
    {
        if (str_starts_with($publicId, 'local::')) {
            try {
                $relativePath = substr($publicId, 7);
                $filePath = public_path('uploads/' . $relativePath);
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
                return true;
            } catch (\Exception $e) {
                Log::error('Local file delete failed: ' . $e->getMessage());
                return false;
            }
        }

        if (!$this->isConfigured || !$this->cloudinary) {
            return false;
        }

        try {
            $this->cloudinary->uploadApi()->destroy($publicId);
            return true;
        } catch (\Exception $e) {
            Log::error('Cloudinary delete failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Lấy public_id từ URL Cloudinary hoặc URL cục bộ
     */
    public function extractPublicId(string $url): ?string
    {
        if (str_contains($url, '/uploads/')) {
            if (preg_match('/uploads\/(.+)$/', $url, $matches)) {
                return 'local::' . $matches[1];
            }
        }

        // Dạng URL: https://res.cloudinary.com/{cloud_name}/image/upload/{version}/{public_id}.{ext}
        if (preg_match('/upload\/(?:v\d+\/)?(.+?)(?:\.[a-z]+)?$/', $url, $matches)) {
            return $matches[1];
        }
        return null;
    }
}
