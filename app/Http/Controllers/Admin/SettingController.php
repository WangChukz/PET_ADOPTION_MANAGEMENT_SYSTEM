<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = request()->user()->isAdmin() ? \App\Models\User::all() : collect();
        
        $chatboxService = app(\App\Services\ChatboxService::class);
        $chatboxSettings = $chatboxService->getSettings();
        
        // Tính lượng token đã sử dụng của mỗi user trong 7 ngày gần đây
        $sevenDaysAgo = time() - (7 * 24 * 60 * 60);
        $userUsageMap = [];
        foreach ($chatboxSettings['userTokenUsage'] ?? [] as $usage) {
            if (($usage['timestamp'] ?? 0) >= $sevenDaysAgo) {
                $uid = $usage['userId'];
                $userUsageMap[$uid] = ($userUsageMap[$uid] ?? 0) + ($usage['tokens'] ?? 0);
            }
        }

        $roleLimits = $chatboxSettings['weeklyRoleLimits'] ?? [
            'admin' => 200000,
            'staff' => 100000,
            'user' => 50000
        ];
        foreach ($users as $user) {
            $used = $userUsageMap[$user->Ma_nguoi_dung] ?? 0;
            $user->chatbox_used_tokens = $used;
            
            $role = 'user';
            if ($user->hasRole('admin')) {
                $role = 'admin';
            } elseif ($user->hasRole('staff')) {
                $role = 'staff';
            }
            
            $limit = $roleLimits[$role] ?? ($chatboxSettings['weeklyTokenLimit'] ?? 50000);
            $user->chatbox_remaining_tokens = max(0, $limit - $used);
        }

        return view('admin.settings.index', compact('users', 'chatboxSettings'));
    }
}
