<x-admin-layout>
    <x-slot name="header">
        <span class="text-slate-500">Hệ Thống</span>
        <svg class="w-4 h-4 mx-1 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
        <span class="text-slate-900 font-medium">Cài Đặt</span>
    </x-slot>

    <div class="max-w-7xl mx-auto space-y-6" x-data="{ activeTab: window.location.hash ? window.location.hash.substring(1) : 'general' }" @hashchange.window="activeTab = window.location.hash ? window.location.hash.substring(1) : 'general'">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-8">
            <div>
                <h2 class="text-2xl font-bold text-slate-900 mb-1">Cài Đặt Hệ Thống</h2>
                <p class="text-sm text-slate-500">Cấu hình các thông số cơ bản và tùy chỉnh hoạt động của hệ thống.</p>
            </div>
            <div class="flex items-center gap-3" x-show="activeTab === 'general'">
                <button class="bg-teal-700 text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-teal-800 hover:shadow-md transition-all shadow-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                    Lưu Thay Đổi
                </button>
            </div>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Settings Sidebar -->
            <div class="w-full lg:w-64 shrink-0">
                <div class="bg-white border border-slate-200 rounded-xl shadow overflow-hidden">
                    <nav class="flex flex-col">
                        <a href="#general" @click="activeTab = 'general'" class="flex items-center gap-3 px-4 py-3.5 transition-colors border-l-4"
                           :class="activeTab === 'general' ? 'bg-teal-50 text-teal-700 border-teal-600 font-semibold' : 'text-slate-600 border-transparent hover:bg-slate-50 hover:text-slate-900 font-medium'">
                            <svg class="w-5 h-5" :class="activeTab === 'general' ? 'text-teal-700' : 'text-slate-400'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            Thông tin chung
                        </a>
                        <a href="#email" @click="activeTab = 'email'" class="flex items-center gap-3 px-4 py-3.5 transition-colors border-l-4"
                           :class="activeTab === 'email' ? 'bg-teal-50 text-teal-700 border-teal-600 font-semibold' : 'text-slate-600 border-transparent hover:bg-slate-50 hover:text-slate-900 font-medium'">
                            <svg class="w-5 h-5" :class="activeTab === 'email' ? 'text-teal-700' : 'text-slate-400'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            Cài đặt Email
                        </a>
                        <a href="#payment" @click="activeTab = 'payment'" class="flex items-center gap-3 px-4 py-3.5 transition-colors border-l-4"
                           :class="activeTab === 'payment' ? 'bg-teal-50 text-teal-700 border-teal-600 font-semibold' : 'text-slate-600 border-transparent hover:bg-slate-50 hover:text-slate-900 font-medium'">
                            <svg class="w-5 h-5" :class="activeTab === 'payment' ? 'text-teal-700' : 'text-slate-400'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                            Thanh toán
                        </a>
                        <a href="#notification" @click="activeTab = 'notification'" class="flex items-center gap-3 px-4 py-3.5 transition-colors border-l-4"
                           :class="activeTab === 'notification' ? 'bg-teal-50 text-teal-700 border-teal-600 font-semibold' : 'text-slate-600 border-transparent hover:bg-slate-50 hover:text-slate-900 font-medium'">
                            <svg class="w-5 h-5" :class="activeTab === 'notification' ? 'text-teal-700' : 'text-slate-400'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                            Thông báo
                        </a>
                        <a href="#roles" @click="activeTab = 'roles'" class="flex items-center gap-3 px-4 py-3.5 transition-colors border-l-4"
                           :class="activeTab === 'roles' ? 'bg-teal-50 text-teal-700 border-teal-600 font-semibold' : 'text-slate-600 border-transparent hover:bg-slate-50 hover:text-slate-900 font-medium'">
                            <svg class="w-5 h-5" :class="activeTab === 'roles' ? 'text-teal-700' : 'text-slate-400'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                            Phân quyền
                        </a>
                        <a href="#backup" @click="activeTab = 'backup'" class="flex items-center gap-3 px-4 py-3.5 transition-colors border-l-4"
                           :class="activeTab === 'backup' ? 'bg-teal-50 text-teal-700 border-teal-600 font-semibold' : 'text-slate-600 border-transparent hover:bg-slate-50 hover:text-slate-900 font-medium'">
                            <svg class="w-5 h-5" :class="activeTab === 'backup' ? 'text-teal-700' : 'text-slate-400'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"></path></svg>
                            Sao lưu & Phục hồi
                        </a>
                        <a href="#chatbox" @click="activeTab = 'chatbox'" class="flex items-center gap-3 px-4 py-3.5 transition-colors border-l-4"
                           :class="activeTab === 'chatbox' ? 'bg-teal-50 text-teal-700 border-teal-600 font-semibold' : 'text-slate-600 border-transparent hover:bg-slate-50 hover:text-slate-900 font-medium'">
                            <svg class="w-5 h-5" :class="activeTab === 'chatbox' ? 'text-teal-700' : 'text-slate-400'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                            Cấu hình Chatbox AI
                        </a>
                        <a href="#logs" @click="activeTab = 'logs'" class="flex items-center gap-3 px-4 py-3.5 transition-colors border-l-4"
                           :class="activeTab === 'logs' ? 'bg-teal-50 text-teal-700 border-teal-600 font-semibold' : 'text-slate-600 border-transparent hover:bg-slate-50 hover:text-slate-900 font-medium'">
                            <svg class="w-5 h-5" :class="activeTab === 'logs' ? 'text-teal-700' : 'text-slate-400'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                            Nhật ký hệ thống
                        </a>
                    </nav>
                </div>
            </div>

            <!-- Main Content Form -->
            <div class="flex-1 space-y-6">
                <!-- General Info View -->
                <div x-show="activeTab === 'general'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0" style="display: none;" class="space-y-6">
                    <!-- Basic Info Card -->
                    <div class="bg-white border border-slate-200 rounded-xl shadow p-6 lg:p-8">
                        <h3 class="text-lg font-bold text-slate-900 mb-6">Thông Tin Cơ Bản</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Logo Upload -->
                            <div class="col-span-1 md:col-span-2 flex items-start gap-6">
                                <div class="w-24 h-24 rounded-2xl bg-slate-50 border-2 border-dashed border-slate-300 flex items-center justify-center shrink-0 relative group cursor-pointer hover:bg-slate-100 hover:border-teal-500 transition-colors">
                                    <svg class="w-8 h-8 text-slate-400 group-hover:text-teal-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    <!-- <img src="logo.png" class="w-full h-full object-cover rounded-2xl" /> -->
                                </div>
                                <div class="flex flex-col">
                                    <span class="font-semibold text-slate-900 mb-1">Logo Hệ Thống</span>
                                    <span class="text-xs text-slate-500 mb-3 leading-relaxed max-w-sm">Tải lên logo để hiển thị ở góc trái trên cùng của màn hình admin và trang chủ. Khuyên dùng ảnh PNG vuông hoặc chữ nhật ngang (Max 2MB).</span>
                                    <button type="button" class="px-4 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm font-semibold text-slate-700 hover:bg-slate-100 transition-colors w-fit">
                                        Tải ảnh lên
                                    </button>
                                </div>
                            </div>

                            <!-- System Name -->
                            <div class="col-span-1 md:col-span-2">
                                <label class="block text-sm font-bold text-slate-700 mb-1.5">Tên Hệ Thống</label>
                                <input type="text" value="PetAdoption Admin" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-teal-500 focus:ring-1 focus:ring-teal-500 transition-colors shadow-sm text-slate-900">
                            </div>

                            <!-- Slogan -->
                            <div class="col-span-1 md:col-span-2">
                                <label class="block text-sm font-bold text-slate-700 mb-1.5">Slogan / Mô tả ngắn</label>
                                <input type="text" value="Nền tảng quản lý nhận nuôi thú cưng hàng đầu" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-teal-500 focus:ring-1 focus:ring-teal-500 transition-colors shadow-sm text-slate-900">
                            </div>

                            <!-- Email -->
                            <div class="col-span-1">
                                <label class="block text-sm font-bold text-slate-700 mb-1.5">Email Liên Hệ</label>
                                <input type="email" value="contact@petadoption.com" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-teal-500 focus:ring-1 focus:ring-teal-500 transition-colors shadow-sm text-slate-900">
                            </div>

                            <!-- Hotline -->
                            <div class="col-span-1">
                                <label class="block text-sm font-bold text-slate-700 mb-1.5">Hotline</label>
                                <input type="text" value="1900 1234" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-teal-500 focus:ring-1 focus:ring-teal-500 transition-colors shadow-sm text-slate-900">
                            </div>

                            <!-- Address -->
                            <div class="col-span-1 md:col-span-2">
                                <label class="block text-sm font-bold text-slate-700 mb-1.5">Địa Chỉ Trụ Sở</label>
                                <textarea rows="2" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-teal-500 focus:ring-1 focus:ring-teal-500 transition-colors shadow-sm text-slate-900 resize-none">123 Đường Xuân Thủy, Cầu Giấy, Hà Nội</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Regional Settings -->
                    <div class="bg-white border border-slate-200 rounded-xl shadow p-6 lg:p-8">
                        <h3 class="text-lg font-bold text-slate-900 mb-6">Khu Vực & Ngôn Ngữ</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Language -->
                            <div class="col-span-1">
                                <label class="block text-sm font-bold text-slate-700 mb-1.5">Ngôn Ngữ Mặc Định</label>
                                <select class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-teal-500 focus:ring-1 focus:ring-teal-500 appearance-none shadow-sm text-slate-900">
                                    <option>Tiếng Việt (vi)</option>
                                    <option>English (en)</option>
                                </select>
                            </div>

                            <!-- Timezone -->
                            <div class="col-span-1">
                                <label class="block text-sm font-bold text-slate-700 mb-1.5">Múi Giờ</label>
                                <select class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-teal-500 focus:ring-1 focus:ring-teal-500 appearance-none shadow-sm text-slate-900">
                                    <option>Asia/Ho_Chi_Minh (+07:00)</option>
                                    <option>Asia/Bangkok (+07:00)</option>
                                </select>
                            </div>

                            <!-- Date Format -->
                            <div class="col-span-1">
                                <label class="block text-sm font-bold text-slate-700 mb-1.5">Định Dạng Ngày</label>
                                <select class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-teal-500 focus:ring-1 focus:ring-teal-500 appearance-none shadow-sm text-slate-900">
                                    <option>DD/MM/YYYY</option>
                                    <option>MM/DD/YYYY</option>
                                    <option>YYYY-MM-DD</option>
                                </select>
                            </div>

                            <!-- Time Format -->
                            <div class="col-span-1">
                                <label class="block text-sm font-bold text-slate-700 mb-1.5">Định Dạng Giờ</label>
                                <select class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-teal-500 focus:ring-1 focus:ring-teal-500 appearance-none shadow-sm text-slate-900">
                                    <option>24 Giờ (14:30)</option>
                                    <option>12 Giờ (02:30 PM)</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Advanced Options -->
                    <div class="bg-white border border-slate-200 rounded-xl shadow p-6 lg:p-8">
                        <h3 class="text-lg font-bold text-slate-900 mb-6">Tùy Chọn Hoạt Động</h3>
                        
                        <div class="space-y-6">
                            <!-- Toggle 1 -->
                            <div class="flex items-center justify-between" x-data="{ on: true }">
                                <div>
                                    <h4 class="font-bold text-slate-900 mb-1">Cho phép Đăng ký Tài khoản mới</h4>
                                    <p class="text-sm text-slate-500">Mở cổng đăng ký tài khoản cho khách truy cập vãng lai.</p>
                                </div>
                                <button type="button" @click="on = !on" class="relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2" :class="on ? 'bg-teal-500' : 'bg-slate-200'">
                                    <span class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out" :class="on ? 'translate-x-5' : 'translate-x-0'"></span>
                                </button>
                            </div>

                            <hr class="border-slate-100">

                            <!-- Toggle 2 -->
                            <div class="flex items-center justify-between" x-data="{ on: false }">
                                <div>
                                    <h4 class="font-bold text-slate-900 mb-1">Chế Độ Bảo Trì</h4>
                                    <p class="text-sm text-slate-500">Tạm dừng tất cả giao dịch và hiển thị thông báo bảo trì cho người dùng ngoài Admin.</p>
                                </div>
                                <button type="button" @click="on = !on" class="relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2" :class="on ? 'bg-red-500' : 'bg-slate-200'">
                                    <span class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out" :class="on ? 'translate-x-5' : 'translate-x-0'"></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Roles Info View -->
                <div x-show="activeTab === 'roles'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0" style="display: none;" class="space-y-6">
                    <div class="bg-white border border-slate-200 rounded-xl shadow p-6 lg:p-8">
                        @if (isset($users) && count($users) > 0)
                            @include('profile.partials.manage-roles-form')
                        @else
                            <div class="text-center py-12">
                                <p class="text-slate-500">Bạn không có quyền truy cập khu vực này.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- CẤU HÌNH CHATBOX AI TAB -->
                <div x-show="activeTab === 'chatbox'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0" style="display: none;" class="space-y-6">
                    
                    <!-- 1. Hạn mức Token tuần theo vai trò -->
                    <div class="bg-white border border-slate-200 rounded-xl shadow p-6 lg:p-8">
                        <h3 class="text-lg font-bold text-slate-900 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Hạn Mức Sử Dụng Token Tuần Theo Vai Trò
                        </h3>
                        <p class="text-sm text-slate-500 mb-6">Mỗi người dùng sẽ bị giới hạn tổng lượng token được tiêu dùng trong 7 ngày gần nhất dựa theo vai trò của mình để bảo mật và tránh quá tải API.</p>
                        
                        <form action="{{ route('admin.chatbox.limit.update') }}" method="POST" class="space-y-4">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">Hạn mức Admin (Token/Tuần)</label>
                                    <input type="number" name="limit_admin" value="{{ $chatboxSettings['weeklyRoleLimits']['admin'] ?? 200000 }}" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-teal-500 focus:ring-1 focus:ring-teal-500 transition-colors shadow-sm text-slate-900 font-semibold" required>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">Hạn mức Nhân viên (Token/Tuần)</label>
                                    <input type="number" name="limit_staff" value="{{ $chatboxSettings['weeklyRoleLimits']['staff'] ?? 100000 }}" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-teal-500 focus:ring-1 focus:ring-teal-500 transition-colors shadow-sm text-slate-900 font-semibold" required>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">Hạn mức Thành viên (Token/Tuần)</label>
                                    <input type="number" name="limit_user" value="{{ $chatboxSettings['weeklyRoleLimits']['user'] ?? 50000 }}" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-teal-500 focus:ring-1 focus:ring-teal-500 transition-colors shadow-sm text-slate-900 font-semibold" required>
                                </div>
                            </div>
                            <div class="flex justify-end pt-2">
                                <button type="submit" class="bg-teal-700 text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-teal-800 transition-all cursor-pointer shadow-sm">
                                    Lưu Hạn Mức
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- 2. Quản lý Groq API Keys -->
                    <div class="bg-white border border-slate-200 rounded-xl shadow p-6 lg:p-8">
                        <h3 class="text-lg font-bold text-slate-900 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m-5 8a2 2 0 01-2-2V7a2 2 0 012-2h5a2 2 0 012 2v5a2 2 0 01-2 2h-5z"></path></svg>
                            Quản Lý Groq API Keys & Hạn Mức
                        </h3>
                        <p class="text-sm text-slate-500 mb-6">Thêm các Groq API Keys để chạy Chatbox AI. Hệ thống sẽ tự động xác thực và luân chuyển round-robin giữa các key này để giảm tải và tránh rate limit.</p>

                        <!-- Form thêm key mới -->
                        <form action="{{ route('admin.chatbox.keys.add') }}" method="POST" class="max-w-2xl flex items-end gap-4 mb-8">
                            @csrf
                            <div class="flex-1">
                                <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">Thêm Groq API Key mới</label>
                                <input type="password" name="api_key" placeholder="gsk_..." class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-teal-500 focus:ring-1 focus:ring-teal-500 transition-colors shadow-sm text-slate-900" required>
                            </div>
                            <button type="submit" class="bg-teal-700 text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-teal-800 transition-all cursor-pointer whitespace-nowrap">
                                Xác Minh & Thêm
                            </button>
                        </form>

                        <!-- Danh sách key hiện tại -->
                        <h4 class="text-sm font-bold text-slate-800 mb-3">Danh Sách Keys Đang Hoạt Động ({{ count($chatboxSettings['api_keys'] ?? []) }})</h4>
                        @if(empty($chatboxSettings['api_keys']))
                            <div class="text-center py-6 bg-slate-50 border border-slate-200 border-dashed rounded-xl">
                                <p class="text-sm text-slate-400">Chưa có API Key nào hoạt động. Hệ thống sẽ sử dụng key mặc định từ file cấu hình .env (nếu có).</p>
                            </div>
                        @else
                            <div class="border border-slate-200 rounded-xl overflow-hidden bg-slate-50/20">
                                <table class="w-full text-left border-collapse text-sm">
                                    <thead>
                                        <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 font-semibold">
                                            <th class="px-6 py-3">Groq API Key</th>
                                            <th class="px-6 py-3">Token còn lại / Hạn mức</th>
                                            <th class="px-6 py-3">Trạng thái</th>
                                            <th class="px-6 py-3 text-right">Hành động</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-100">
                                        @foreach($chatboxSettings['api_keys'] as $keyItem)
                                            @php
                                                $actualKey = is_array($keyItem) ? ($keyItem['key'] ?? '') : $keyItem;
                                                $limitTokens = is_array($keyItem) ? ($keyItem['limit_tokens'] ?? 0) : 0;
                                                $remTokens = is_array($keyItem) ? ($keyItem['remaining_tokens'] ?? 0) : 0;
                                                $limitReqs = is_array($keyItem) ? ($keyItem['limit_requests'] ?? 0) : 0;
                                                $remReqs = is_array($keyItem) ? ($keyItem['remaining_requests'] ?? 0) : 0;
                                                $lastUsed = is_array($keyItem) ? ($keyItem['last_used'] ?? null) : null;
                                                $status = is_array($keyItem) ? ($keyItem['status'] ?? 'active') : 'active';
                                            @endphp
                                            <tr class="hover:bg-slate-50/50 transition-colors">
                                                <td class="px-6 py-4 font-mono text-slate-600">
                                                    {{ substr($actualKey, 0, 8) . '...' . substr($actualKey, -6) }}
                                                </td>
                                                <td class="px-6 py-4 text-slate-700">
                                                    @if($limitTokens > 0)
                                                        <span class="font-semibold text-slate-900">{{ number_format($remTokens) }}</span> <span class="text-slate-400">/ {{ number_format($limitTokens) }}</span>
                                                    @else
                                                        <span class="text-slate-400">Chưa bắt đầu</span>
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4">
                                                    @if($status === 'active')
                                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200/40">Hoạt động</span>
                                                    @else
                                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-200/40">Lỗi</span>
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 text-right">
                                                    <form action="{{ route('admin.chatbox.keys.delete') }}" method="POST" class="inline" onsubmit="return confirm('Bạn chắc chắn muốn xóa API Key này?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <input type="hidden" name="api_key" value="{{ $actualKey }}">
                                                        <button type="submit" class="text-rose-600 hover:text-rose-800 font-semibold cursor-pointer">Xóa</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>

                    <!-- 3. Thống kê token và hạn mức còn lại của user -->
                    <div class="bg-white border border-slate-200 rounded-xl shadow p-6 lg:p-8">
                        <h3 class="text-lg font-bold text-slate-900 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            Hạn Mức & Token Còn Lại Của Mỗi Tài Khoản
                        </h3>
                        <p class="text-sm text-slate-500 mb-6">Thống kê lượng token đã sử dụng trong 7 ngày gần đây và số token còn lại cho phép của từng tài khoản trong hệ thống.</p>
                        
                        <div class="border border-slate-200 rounded-xl overflow-hidden bg-slate-50/20">
                            <table class="w-full text-left border-collapse text-sm">
                                <thead>
                                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 font-semibold">
                                        <th class="px-6 py-3">Người dùng</th>
                                        <th class="px-6 py-3">Email</th>
                                        <th class="px-6 py-3">Token đã dùng (7 ngày)</th>
                                        <th class="px-6 py-3">Token còn lại</th>
                                        <th class="px-6 py-3">Trạng thái</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @foreach($users as $user)
                                        <tr class="hover:bg-slate-50/50 transition-colors">
                                            <td class="px-6 py-4 font-semibold text-slate-800">
                                                {{ $user->Ho_ten }}
                                                @if($user->isAdmin())
                                                    <span class="ml-1.5 px-2 py-0.5 text-[10px] font-bold bg-amber-50 text-amber-700 rounded-full border border-amber-200/50">Admin</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-slate-600">{{ $user->Email }}</td>
                                            <td class="px-6 py-4 font-mono text-slate-700">
                                                {{ number_format($user->chatbox_used_tokens ?? 0) }}
                                            </td>
                                            <td class="px-6 py-4 font-mono font-semibold text-slate-800">
                                                {{ number_format($user->chatbox_remaining_tokens ?? 0) }}
                                            </td>
                                            <td class="px-6 py-4">
                                                @if(($user->chatbox_remaining_tokens ?? 0) > 0)
                                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200/40">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                                        Khả dụng
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-200/40">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                                        Hết hạn mức
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</x-admin-layout>
