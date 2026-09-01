<aside 
    class="flex flex-col bg-sidebar-blue shadow-lg transition-all duration-300 ease-in-out shrink-0 h-full relative z-20 text-white"
    :class="expanded ? 'w-52' : 'w-16'"
>
    <!-- Sidebar Header (Logo + Toggle) -->
    <div class="h-16 flex items-center px-4 shrink-0 transition-all duration-300" :class="expanded ? 'justify-between' : 'justify-center'">
        <!-- Logo -->
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 overflow-hidden">
            <!-- Logo Image -->
            <img src="{{ asset('favicon.ico') }}" class="w-10 h-10 object-contain shrink-0" alt="Logo">
            <div class="flex flex-col" x-show="expanded">
                <span class="text-[16px] font-black tracking-tight text-white leading-none">PetJam</span>
                <span class="text-[9px] font-bold text-white/70 tracking-[0.22em] uppercase mt-1">Trang quản trị</span>
            </div>
        </a>

        <!-- Toggle Button -->
        <button 
            @click="expanded = !expanded" 
            class="absolute -right-3 top-6 bg-sidebar-blue border-2 border-[#F4F7F6] rounded-full p-0.5 text-white hover:bg-teal-700 transition-colors shadow-md z-50"
        >
            <svg class="w-3.5 h-3.5 transition-transform duration-300" :class="expanded ? 'rotate-0' : 'rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path>
            </svg>
        </button>
    </div>

    <!-- Navigation Links -->
    <nav class="flex-1 overflow-y-auto px-2 pb-2 custom-scrollbar">
        
        <!-- SECTION: TỔNG QUAN -->
        <div class="mt-2 mb-1">
            <h3 x-show="expanded" class="px-2 text-[9px] font-bold text-white/50 uppercase tracking-widest">Tổng Quan</h3>
            <div x-show="!expanded" class="h-3 border-b border-white/10 mx-2 mb-2"></div>
        </div>
        
        <div class="space-y-0.5">
            <a href="{{ route('dashboard') }}" 
               class="flex items-center gap-2.5 px-2 py-1.5 rounded-lg transition-colors group {{ request()->routeIs('dashboard') ? 'bg-white/15 text-white font-bold' : 'text-white/80 hover:bg-white/10 hover:text-white font-medium' }}"
               :class="!expanded && 'justify-center px-0'"
            >
                <svg class="w-[18px] h-[18px] shrink-0 {{ request()->routeIs('dashboard') ? 'text-orange-brand' : 'text-white/80 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                </svg>
                <span class="text-[12px] truncate" x-show="expanded">Dashboard</span>
            </a>
        </div>

        <!-- SECTION: QUẢN LÝ -->
        <div class="mt-3 mb-1">
            <h3 x-show="expanded" class="px-2 text-[9px] font-bold text-white/50 uppercase tracking-widest">Quản Lý</h3>
            <div x-show="!expanded" class="h-3 border-b border-white/10 mx-2 mb-2"></div>
        </div>

        <div class="space-y-0.5">
            <!-- Thú Cưng -->
            <a href="{{ route('admin.pets.index') }}" 
               class="flex items-center gap-2.5 px-2 py-1.5 rounded-lg transition-colors group {{ request()->routeIs('admin.pets.*') ? 'bg-white/15 text-white font-bold' : 'text-white/80 hover:bg-white/10 hover:text-white font-medium' }}"
               :class="!expanded && 'justify-center px-0'"
            >
                <svg class="w-[18px] h-[18px] shrink-0 {{ request()->routeIs('admin.pets.*') ? 'text-orange-brand' : 'text-white/80 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M11 5h2a6 6 0 0 1 6 6v2a6 6 0 0 1 -6 6h-2a6 6 0 0 1 -6 -6v-2a6 6 0 0 1 6 -6z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M11 15h2M10 11h.01M14 11h.01"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M5 13c-1.657 0 -3 -1.343 -3 -3c0 -1.657 1.343 -3 3 -3"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M19 13c1.657 0 3 -1.343 3 -3c0 -1.657 -1.343 -3 -3 -3"></path>
                </svg>
                <span class="text-[12px] truncate" x-show="expanded">Thú Cưng</span>
            </a>

            <!-- Đơn Nhận Nuôi Dropdown -->
            <div x-data="{ open: {{ request()->routeIs('admin.adoptions.*') || request()->routeIs('admin.interview_schedules.*') ? 'true' : 'false' }} }" class="space-y-0.5">
                <button @click="open = !open; if(!expanded) expanded = true" 
                   class="w-full flex items-center justify-between px-2 py-1.5 rounded-lg transition-colors group {{ request()->routeIs('admin.adoptions.*') || request()->routeIs('admin.interview_schedules.*') ? 'bg-white/15 text-white font-bold' : 'text-white/80 hover:bg-white/10 hover:text-white font-medium' }}"
                   :class="!expanded && 'justify-center px-0'"
                >
                    <div class="flex items-center gap-2.5">
                        <svg class="w-[18px] h-[18px] shrink-0 {{ request()->routeIs('admin.adoptions.*') || request()->routeIs('admin.interview_schedules.*') ? 'text-orange-brand' : 'text-white/80 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                        </svg>
                        <span class="text-[12px] truncate" x-show="expanded">Đơn Nhận Nuôi</span>
                    </div>
                    <svg x-show="expanded" class="w-3.5 h-3.5 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                <div x-show="open && expanded" 
                     x-collapse
                     class="pl-7 pr-2 space-y-0.5 pt-0.5">
                     <a href="{{ route('admin.adoptions.index') }}" class="block px-2 py-1.5 text-[11px] rounded-lg transition-colors {{ request()->routeIs('admin.adoptions.*') ? 'bg-white/15 text-white font-bold' : 'text-white/60 hover:text-white hover:bg-white/10 font-medium' }}">Quản lý Đơn</a>
                     <a href="{{ route('admin.interview_schedules.index') }}" class="block px-2 py-1.5 text-[11px] rounded-lg transition-colors {{ request()->routeIs('admin.interview_schedules.*') ? 'bg-white/15 text-white font-bold' : 'text-white/60 hover:text-white hover:bg-white/10 font-medium' }}">Lịch phỏng vấn</a>
                </div>
            </div>

            <!-- Ủng Hộ Dropdown (Ẩn đi theo yêu cầu) 
            <div x-data="{ open: {{ request()->routeIs('admin.donations.*') || request()->routeIs('admin.donation_campaigns.*') ? 'true' : 'false' }} }" class="space-y-0.5">
                <button @click="open = !open; if(!expanded) expanded = true" 
                   class="w-full flex items-center justify-between px-2 py-1.5 rounded-lg transition-colors group {{ request()->routeIs('admin.donations.*') || request()->routeIs('admin.donation_campaigns.*') ? 'bg-white/15 text-white font-bold' : 'text-white/80 hover:bg-white/10 hover:text-white font-medium' }}"
                   :class="!expanded && 'justify-center px-0'"
                >
                    <div class="flex items-center gap-2.5">
                        <svg class="w-[18px] h-[18px] shrink-0 {{ request()->routeIs('admin.donations.*') || request()->routeIs('admin.donation_campaigns.*') ? 'text-orange-brand' : 'text-white/80 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                        <span class="text-[12px] truncate" x-show="expanded">Ủng Hộ</span>
                    </div>
                    <svg x-show="expanded" class="w-3.5 h-3.5 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                <div x-show="open && expanded" 
                     x-collapse
                     class="pl-7 pr-2 space-y-0.5 pt-0.5">
                     <a href="{{ route('admin.donations.index') }}" class="block px-2 py-1.5 text-[11px] rounded-lg transition-colors {{ request()->routeIs('admin.donations.index') || request()->routeIs('admin.donations.show') ? 'bg-white/15 text-white font-bold' : 'text-white/60 hover:text-white hover:bg-white/10 font-medium' }}">Quản lý Ủng hộ</a>
                     <a href="{{ route('admin.donation_campaigns.index') }}" class="block px-2 py-1.5 text-[11px] rounded-lg transition-colors {{ request()->routeIs('admin.donation_campaigns.*') ? 'bg-white/15 text-white font-bold' : 'text-white/60 hover:text-white hover:bg-white/10 font-medium' }}">Chiến dịch Gây quỹ</a>
                </div>
            </div>
            -->


            <!-- Quản Lý Người Dùng (Ẩn theo yêu cầu) 
            @can('access_users')
            <a href="{{ route('admin.users.index') }}" 
               class="flex items-center gap-2.5 px-2 py-1.5 rounded-lg transition-colors group {{ request()->routeIs('admin.users.*') ? 'bg-white/15 text-white shadow-inner font-semibold' : 'text-white/80 hover:bg-white/10 hover:text-white font-medium' }}"
               :class="!expanded ? 'justify-center px-0' : ''">
                <div class="relative flex items-center justify-center">
                    <svg class="w-[18px] h-[18px] shrink-0 transition-transform duration-300 group-hover:scale-110 {{ request()->routeIs('admin.users.*') ? 'text-white' : 'text-white/70 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
                <span class="text-[12px] truncate transition-opacity duration-300" x-show="expanded" x-transition:enter="transition-opacity ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">Người Dùng</span>
            </a>
            @endcan
            -->
        </div>

        @can('access_settings')
        <!-- SECTION: CÀI ĐẶT -->
        <div class="mt-3 mb-1">
            <h3 x-show="expanded" class="px-2 text-[9px] font-bold text-white/50 uppercase tracking-widest">Cài Đặt</h3>
            <div x-show="!expanded" class="h-3 border-b border-white/10 mx-2 mb-2"></div>
        </div>
        @endcan

        <div class="space-y-0.5">

            @can('access_settings')
            <!-- Cài Đặt Hệ Thống -->
            <a href="{{ route('admin.settings.index') }}" 
               class="flex items-center gap-2.5 px-2 py-1.5 rounded-lg transition-colors group {{ request()->routeIs('admin.settings.*') ? 'bg-white/15 text-white shadow-inner font-semibold' : 'text-white/80 hover:bg-white/10 hover:text-white font-medium' }}"
               :class="!expanded ? 'justify-center px-0' : ''">
                <div class="relative flex items-center justify-center">
                    <svg class="w-[18px] h-[18px] shrink-0 transition-transform duration-300 group-hover:rotate-90 {{ request()->routeIs('admin.settings.*') ? 'text-white' : 'text-white/70 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                </div>
                <span class="text-[12px] truncate transition-opacity duration-300" x-show="expanded" x-transition:enter="transition-opacity ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">Hệ Thống</span>
            </a>
            @endcan

            <!-- Cài Đặt Tài Khoản -->
            <a href="{{ route('profile.edit') }}" 
               class="flex items-center gap-2.5 px-2 py-1.5 rounded-lg transition-colors group {{ request()->routeIs('profile.edit') ? 'bg-white/15 text-white shadow-inner font-semibold' : 'text-white/80 hover:bg-white/10 hover:text-white font-medium' }}"
               :class="!expanded ? 'justify-center px-0' : ''">
                <div class="relative flex items-center justify-center">
                    <svg class="w-[18px] h-[18px] shrink-0 transition-transform duration-300 group-hover:scale-110 {{ request()->routeIs('profile.edit') ? 'text-white' : 'text-white/70 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                </div>
                <span class="text-[12px] truncate transition-opacity duration-300" x-show="expanded" x-transition:enter="transition-opacity ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">Tài Khoản</span>
            </a>
        </div>
    </nav>

    <!-- Sidebar Footer -->
    <div class="p-2 shrink-0 mt-auto">
        <!-- Back to Website Button matching the image style -->
        <a href="/" 
           class="flex items-center justify-center gap-2 w-full px-2 py-2 rounded-lg border border-white/20 bg-white/5 hover:bg-white/15 text-white font-bold transition-colors group"
           :class="!expanded && 'px-0'"
           title="Quay về trang web"
        >
            <svg class="w-[18px] h-[18px] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
            </svg>
            <span class="text-[12px]" x-show="expanded">Quay về trang web</span>
        </a>

        <!-- Logout Button -->
        <form method="POST" action="{{ route('logout') }}" class="mt-1.5">
            @csrf
            <button
                type="submit"
                class="flex items-center justify-center gap-2 w-full px-2 py-2 rounded-lg bg-[#e75e5b] hover:bg-red-500 text-white font-bold transition-colors group"
                :class="!expanded && 'px-0'"
                title="Đăng xuất"
            >
                <svg class="w-[18px] h-[18px] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                </svg>
                <span class="text-[12px]" x-show="expanded">Đăng xuất</span>
            </button>
        </form>
    </div>
</aside>

<style>
/* Hide scrollbar for sidebar but allow scroll */
.custom-scrollbar::-webkit-scrollbar {
    width: 3px;
}
.custom-scrollbar::-webkit-scrollbar-track {
    background: transparent;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
    background-color: rgba(255, 255, 255, 0.2);
    border-radius: 3px;
}
.custom-scrollbar:hover::-webkit-scrollbar-thumb {
    background-color: rgba(255, 255, 255, 0.3);
}
</style>
