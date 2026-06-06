<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // Lịch sử nhận nuôi của user
    Route::get('/tai-khoan/lich-su-nhan-nuoi', [\App\Http\Controllers\Frontend\UserAdoptionController::class, 'index'])
        ->name('frontend.user.adoptions.index');
    Route::post('/tai-khoan/don-nhan-nuoi/{id}/xep-lich', [\App\Http\Controllers\Frontend\UserAdoptionController::class, 'scheduleInterview'])
        ->name('frontend.user.adoptions.schedule-interview');
});

// ── Khu vực Admin ───────────────────────────────────────────────────────────
Route::middleware(['auth', 'verified', 'admin'])->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Quản lý Phân Quyền (Roles & Permissions)
    Route::get('/admin/roles', [\App\Http\Controllers\Admin\RolePermissionController::class, 'index'])->name('admin.roles.index');
    Route::post('/admin/roles', [\App\Http\Controllers\Admin\RolePermissionController::class, 'storeRole'])->name('admin.roles.store');
    Route::post('/admin/roles/{role}/permissions', [\App\Http\Controllers\Admin\RolePermissionController::class, 'updatePermissions'])->name('admin.roles.permissions.update');

    // Quản lý gán Role cho User
    Route::patch('/admin/users/{user}/role', [\App\Http\Controllers\Admin\UserController::class, 'updateRole'])->name('admin.users.role.update');

    // Thú cưng (full CRUD)
    Route::resource('admin/pets', \App\Http\Controllers\Admin\PetController::class, ['as' => 'admin']);

    // Đơn nhận nuôi (full CRUD + update status)
    Route::resource('admin/adoptions', \App\Http\Controllers\Admin\AdoptionController::class, ['as' => 'admin']);

    // Lịch phỏng vấn
    Route::put('admin/interview_schedules/{id}/hide', [\App\Http\Controllers\Admin\InterviewScheduleController::class, 'hide'])->name('admin.interview_schedules.hide');
    Route::resource('admin/interview_schedules', \App\Http\Controllers\Admin\InterviewScheduleController::class, ['as' => 'admin']);

    // Chiến dịch ủng hộ
    Route::put('admin/donation_campaigns/{id}/close', [\App\Http\Controllers\Admin\DonationCampaignController::class, 'close'])->name('admin.donation_campaigns.close');
    Route::resource('admin/donation_campaigns', \App\Http\Controllers\Admin\DonationCampaignController::class, ['as' => 'admin']);

    // Donations
    Route::resource('admin/donations', \App\Http\Controllers\Admin\DonationController::class, ['as' => 'admin'])->only(['index', 'show']);
        
    // Quản lý ca phỏng vấn (sử dụng interview_schedules)

    // Bài đăng / Tin tức
    Route::resource('admin/posts', \App\Http\Controllers\Admin\PostController::class, ['as' => 'admin']);

    // Người dùng
    Route::resource('admin/users', \App\Http\Controllers\Admin\UserController::class, ['as' => 'admin']);
 
    // Cài đặt
    Route::resource('admin/settings', \App\Http\Controllers\Admin\SettingController::class, ['as' => 'admin']);

    // Cấu hình Chatbox AI (Admin)
    Route::post('admin/chatbox/settings/limit', [\App\Http\Controllers\ChatboxController::class, 'updateLimit'])->name('admin.chatbox.limit.update');
    Route::post('admin/chatbox/settings/keys', [\App\Http\Controllers\ChatboxController::class, 'addKey'])->name('admin.chatbox.keys.add');
    Route::delete('admin/chatbox/settings/keys', [\App\Http\Controllers\ChatboxController::class, 'deleteKey'])->name('admin.chatbox.keys.delete');
});

// API Chatbox Message (Authenticated Users)
Route::post('/chatbox/message', [\App\Http\Controllers\ChatboxController::class, 'sendMessage'])
    ->middleware('auth')
    ->name('chatbox.message');

require __DIR__.'/auth.php';

