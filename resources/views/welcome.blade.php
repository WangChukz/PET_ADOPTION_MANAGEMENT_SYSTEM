@extends('layouts.frontend')
@section('title', 'Trang chủ')

@section('styles')
    <style>
        /* Custom Native Slider Hide Scrollbar */
        #pets-slider::-webkit-scrollbar {
            display: none;
        }
    </style>
@endsection

@section('content')
<div class="w-full overflow-hidden">
<section class="relative pt-24 lg:pt-40 pb-10 lg:pb-20 px-6 lg:px-16 max-w-[1400px] mx-auto flex flex-col-reverse lg:flex-row items-center gap-6 lg:gap-12">
    <!-- Left Text Content -->
    <div class="w-full lg:w-1/2 flex flex-col items-center text-center lg:items-start lg:text-left relative z-10 pt-4 lg:pt-0">
        <!-- Floating paw decorative left behind text -->
        <svg class="absolute -top-10 -left-10 w-24 h-24 text-[#E8F6F8] fill-current -z-10 transform -rotate-12" viewBox="0 0 512 512"><path d="M226.5 92.9c14.3 42.9-.3 86.4-32.6 96.8s-70.1-15.6-84.4-58.5c-14.3-42.9.3-86.4 32.6-96.8s70.1 15.6 84.4 58.5zM100.4 198.6c18.9 32.4 14.3 70.1-10.2 84.1s-59.7-1.2-78.5-33.6c-18.9-32.4-14.3-70.1 10.2-84.1s59.6 1.2 78.5 33.6zM225.4 212.3c3.5 1.5 7.1 2.9 10.7 4.1 43.6 14.2 92.5 13.9 135.9-2.9 3.8-1.5 7.4-3.1 11-4.9 31.9-15.7 62-42.4 82.5-76.3 35.8-59.4 14.2-132-48.4-162.2-50.6-24.4-107.5-12.7-145 23.3-37.5-36-94.4-47.7-145-23.3-62.6 30.2-84.2 102.8-48.4 162.2 20.4 33.9 50.5 60.5 82.4 76.2 1.4.7 2.8 1.4 4.3 2.1zM495.2 284c-24.5-14.1-61.9-2.4-80.8 30s-14.3 71.9 10.2 86 61.9 2.4 80.8-30c18.9-32.4 14.3-71.9-10.2-86zM418.7 189.7c-32.3-10.4-64.9 13.2-79.2 56.1s-4.9 88.5 27.4 98.9c32.3 10.4 64.9-13.2 79.2-56.1s4.9-88.5-27.4-98.9z"/></svg>

        <h1 class="text-3xl sm:text-5xl md:text-6xl lg:text-[72px] font-black leading-[1.05] tracking-tight mb-2 lg:mb-4 relative max-w-full">
            <span class="text-dark">Looking for a</span><br />
            <span class="text-primary relative inline-block pr-12 lg:pr-14 mt-1 lg:mt-0">
                Best friend?
                <svg class="absolute right-0 top-1 w-8 h-8 lg:w-10 lg:h-10 text-primary transform rotate-[15deg]" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
            </span>
        </h1>
        
        <p class="text-base lg:text-lg text-dark font-bold mb-6 lg:mb-10">
            Our best beauties are waiting for a home
        </p>

        <div class="flex flex-row items-center justify-center lg:justify-start gap-2 sm:gap-4 mb-8 lg:mb-12 w-full lg:w-max">
            <a href="{{ route('frontend.adoptions.index') }}" class="btn-primary text-xs sm:text-base px-4 sm:px-8 py-3 sm:py-3.5 border border-primary flex-1 lg:flex-none justify-center whitespace-nowrap">
                <i data-lucide="paw-print" class="w-4 h-4 sm:w-5 sm:h-5"></i>
                Nhận nuôi ngay
            </a>
            <!-- 
            <a href="{{ route('frontend.donations.process') }}" class="btn-outline-teal text-xs sm:text-base px-4 sm:px-8 py-3 sm:py-3.5 bg-white border-[1.5px] border-secondary text-secondary flex-1 lg:flex-none justify-center whitespace-nowrap">
                Ủng hộ ngay
            </a>
            -->
        </div>

        <!-- KPIs row -->
        <div class="grid grid-cols-2 md:flex items-start md:items-center justify-items-start justify-center lg:justify-start gap-4 lg:gap-8 mx-auto lg:mx-0 w-full lg:w-max">
            <!-- KPI 1 -->
            <div class="flex flex-col gap-2 w-max">
                <div class="flex items-center gap-3">
                    <div class="w-[56px] h-[56px] flex items-center justify-center">
                        <svg class="w-10 h-10" fill="#0E7490" viewBox="0 0 24 24">
                            <circle cx="4.5" cy="9.5" r="2.5" />
                            <circle cx="9" cy="5.5" r="2.5" />
                            <circle cx="15" cy="5.5" r="2.5" />
                            <circle cx="19.5" cy="9.5" r="2.5" />
                            <path d="M17.34 14.86c-.87-1.02-1.6-1.89-2.48-2.91-.46-.54-1.05-1.08-1.75-1.32-.11-.04-.22-.07-.33-.09-.25-.04-.52-.04-.78-.04s-.53 0-.79.05c-.11.02-.22.05-.33.09-.7.24-1.28.78-1.75 1.32-.87 1.02-1.6 1.89-2.48 2.91-1.31 1.31-2.92 2.76-2.62 4.79.29 1.02 1.02 2.03 2.33 2.32.73.15 3.06-.44 5.54-.44h.18c2.48 0 4.81.58 5.54.44 1.31-.29 2.04-1.31 2.33-2.32.31-2.04-1.3-3.49-2.61-4.8z" />
                        </svg>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-[20px] font-black text-[#0E7490] leading-none">2,300+</span>
                        <span class="text-[13px] font-bold text-[#F58A3C] leading-tight mt-1">Pets</span>
                        <span class="text-muted font-semibold text-[11px]">Được cứu hộ</span>
                    </div>
                </div>
                <div class="flex items-center mt-1">
                    <div class="w-[6px] h-[6px] rounded-full bg-[#0E7490]"></div>
                    <div class="w-16 h-[2px] ml-1" style="background-image: linear-gradient(to right, #0E7490 50%, transparent 50%); background-size: 6px 2px; background-repeat: repeat-x; opacity: 0.3;"></div>
                </div>
            </div>
            <!-- KPI 2 -->
            <div class="flex flex-col gap-2 w-max">
                <div class="flex items-center gap-3">
                    <div class="w-[56px] h-[56px] flex items-center justify-center">
                        <svg class="w-10 h-10" fill="#FA7226" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-[20px] font-black text-[#0E7490] leading-none">3,452+</span>
                        <span class="text-[13px] font-bold text-[#F58A3C] leading-tight mt-1">Thú cưng</span>
                        <span class="text-muted font-semibold text-[11px]">Đã nhận nuôi</span>
                    </div>
                </div>
                <div class="flex items-center mt-1">
                    <div class="w-[6px] h-[6px] rounded-full bg-[#0E7490]"></div>
                    <div class="w-16 h-[2px] ml-1" style="background-image: linear-gradient(to right, #0E7490 50%, transparent 50%); background-size: 6px 2px; background-repeat: repeat-x; opacity: 0.3;"></div>
                </div>
            </div>
            <!-- KPI 3 -->
            <div class="flex flex-col gap-2 w-max col-span-2 md:col-span-1 mx-auto md:mx-0">
                <div class="flex items-center gap-3">
                    <div class="w-[56px] h-[56px] flex items-center justify-center">
                        <svg class="w-10 h-10" fill="#0E7490" viewBox="0 0 24 24"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-[20px] font-black text-[#0E7490] leading-none">1,980+</span>
                        <span class="text-[13px] font-bold text-[#F58A3C] leading-tight mt-1">Khách hàng</span>
                        <span class="text-muted font-semibold text-[11px]">Hài lòng</span>
                    </div>
                </div>
                <div class="flex items-center mt-1">
                    <div class="w-[6px] h-[6px] rounded-full bg-[#F58A3C]"></div>
                    <div class="w-16 h-[2px] ml-1" style="background-image: linear-gradient(to right, #F58A3C 50%, transparent 50%); background-size: 6px 2px; background-repeat: repeat-x; opacity: 0.3;"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Image -->
    <div class="w-full lg:w-1/2 relative flex justify-center items-center mt-2 lg:mt-0 lg:mr-10">
        <!-- Main Dogs & Cat Image (Using the hero-img.png uploaded by user) -->
        <img src="{{ asset('images/hero-img.png') }}" class="relative z-30 w-full lg:w-[135%] scale-100 lg:scale-[1.3] h-auto object-contain" alt="Dogs and Cat Waiting for Adoption">
    </div>
</section>

<!-- Featured Pets Section -->
<section class="py-16 lg:py-40 px-6 lg:px-16 max-w-[1400px] mx-auto relative bg-cute-pattern">
    <div class="flex justify-center md:justify-between items-center mb-8 text-center md:text-left">
        <h2 class="text-3xl font-extrabold text-[#1D2B53] flex items-center gap-2 tracking-tight">
            Thú cưng đang chờ một mái nhà 
            <i data-lucide="heart-handshake" class="w-8 h-8 text-primary"></i>
        </h2>
        <a href="{{ route('frontend.adoptions.index') }}" class="text-sm font-bold text-secondary hidden md:flex items-center gap-1 hover:text-emerald-600 transition-colors">
            Xem tất cả <i data-lucide="arrow-right" class="w-4 h-4"></i>
        </a>
    </div>

    <!-- Cards container with Native CSS Slider -->
    <div class="relative w-full group">
        <!-- Navigation Buttons -->
        <button onclick="document.getElementById('pets-slider').scrollBy({left: -320, behavior: 'smooth'})" class="hidden xl:flex absolute top-[40%] -left-6 z-10 -translate-y-1/2 w-12 h-12 bg-white rounded-full items-center justify-center shadow-[0_4px_15px_rgba(0,0,0,0.06)] border border-gray-100 hover:scale-105 hover:bg-[#FFF5EF] transition-all text-gray-400 hover:text-[#F58A3C] focus:outline-none">
            <i data-lucide="chevron-left" class="w-6 h-6"></i>
        </button>
        
        <div id="pets-slider" class="flex overflow-x-auto snap-x snap-mandatory gap-6 px-2 pb-8 scroll-smooth" style="scrollbar-width: none; -ms-overflow-style: none;">
            @forelse($featuredPets as $pet)
            <div class="snap-start shrink-0 w-[85%] sm:w-[calc(50%-12px)] lg:w-[calc(33.333%-16px)] xl:w-[calc(25%-18px)] h-auto">
                <!-- Pet Card -->
                <div class="bg-white rounded-[24px] overflow-hidden shadow-[0_4px_20px_rgb(0,0,0,0.03)] hover:shadow-[0_12px_30px_rgb(0,0,0,0.08)] transition-all duration-300 border border-gray-100 flex flex-col hover:-translate-y-1 h-full">
                    <div class="relative h-48 sm:h-44 overflow-hidden">
                        <img src="{{ $pet->AnhUrl }}" alt="{{ $pet->Ten }}" class="w-full h-full object-cover">
                        <div class="absolute top-3 left-3 {{ $pet->Loai == 'cho' ? 'bg-[#40C057]' : ($pet->Loai == 'meo' ? 'bg-[#FCC419]' : 'bg-[#0AA5C0]') }} text-white text-[11px] font-medium px-3 py-1 rounded-lg shadow-sm">
                            {{ $pet->LoaiLabel }}
                        </div>
                        <button class="hidden absolute top-3 right-3 w-8 h-8 bg-white rounded-lg flex items-center justify-center text-red-500 border border-red-100 hover:bg-red-50 shadow-sm transition group">
                            <i data-lucide="heart" class="w-4 h-4"></i>
                        </button>
                    </div>
                    
                    <div class="p-5 flex-1 flex flex-col">
                        <h4 class="font-bold text-[16px] text-[#1D2B53] mb-3">{{ $pet->Ten }}</h4>
                        
                        <div class="flex items-center justify-between text-[11px] font-medium text-gray-500 mb-4 gap-1">
                            <div class="flex items-center gap-1.5 truncate"><i data-lucide="calendar" class="w-3.5 h-3.5 text-gray-400 shrink-0"></i> <span class="truncate">{{ $pet->NhomTuoiLabel }}</span></div>
                            <div class="flex items-center gap-1.5 truncate"><i data-lucide="paw-print" class="w-3.5 h-3.5 text-gray-400 shrink-0"></i> <span class="truncate">{{ $pet->GioiTinhLabel }}</span></div>
                            <div class="flex items-center gap-1.5 truncate"><i data-lucide="box" class="w-3.5 h-3.5 text-gray-400 shrink-0"></i> 
                                <span class="truncate">
                                    {{ $pet->Can_nang < 5 ? 'Nhỏ' : ($pet->Can_nang > 15 ? 'Lớn' : 'Trung bình') }}
                                </span>
                            </div>
                        </div>

                        <div class="flex items-center justify-between mt-auto pt-4 border-t border-gray-50">
                            <div class="flex items-center gap-1 text-[11px] text-gray-500 font-medium truncate max-w-[50%]">
                                <i data-lucide="map-pin" class="w-3.5 h-3.5 text-gray-400 flex-shrink-0"></i>
                                <span class="truncate">{{ $pet->ViTriLabel }}</span>
                            </div>
                            @if($pet->Da_tiem_phong)
                                <div class="text-[10px] font-semibold text-emerald-700 bg-emerald-50/80 px-2.5 py-1.5 rounded-lg whitespace-nowrap tracking-wide">
                                    Đã tiêm phòng
                                </div>
                            @elseif($pet->Da_triet_san)
                                <div class="text-[10px] font-semibold text-emerald-700 bg-emerald-50/80 px-2.5 py-1.5 rounded-lg whitespace-nowrap tracking-wide">
                                    Đã triệt sản
                                </div>
                            @else
                                <div class="text-[10px] font-semibold text-emerald-700 bg-emerald-50/80 px-2.5 py-1.5 rounded-lg whitespace-nowrap tracking-wide">
                                    Khỏe mạnh
                                </div>
                            @endif
                        </div>

                        <a href="{{ route('frontend.adoptions.show', $pet->Ma_thu_cung) }}" class="w-full mt-4 bg-[#FFF5EF] hover:bg-orange-100 text-[#F58A3C] font-semibold py-2.5 rounded-lg transition text-[12px] text-center block">
                            Xem chi tiết
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="w-full text-center py-10">
                <p class="text-gray-500 font-medium text-sm">Hiện tại chưa có thú cưng nổi bật nào.</p>
            </div>
            @endforelse
        </div>
        
        <button onclick="document.getElementById('pets-slider').scrollBy({left: 320, behavior: 'smooth'})" class="hidden xl:flex absolute top-[40%] -right-6 z-10 -translate-y-1/2 w-12 h-12 bg-white rounded-full items-center justify-center shadow-[0_4px_15px_rgba(0,0,0,0.06)] border border-gray-100 hover:scale-105 hover:bg-[#FFF5EF] transition-all text-gray-400 hover:text-[#F58A3C] focus:outline-none">
            <i data-lucide="chevron-right" class="w-6 h-6"></i>
        </button>
    </div>
</section>

<!-- Adoption Process -->
<section id="adoption-process" class="py-12 lg:py-20 px-6 lg:px-16 max-w-[1400px] mx-auto relative mt-6 lg:mt-10">
    <div class="flex justify-center md:justify-between items-center mb-12 lg:mb-24 text-center md:text-left w-full">
        <h2 class="text-3xl font-extrabold text-[#1D2B53] flex items-center gap-2 tracking-tight">
            Quy trình nhận nuôi
            <i data-lucide="clipboard-check" class="w-8 h-8 text-[#0AA5C0]"></i>
        </h2>
    </div>
    
    <div class="relative w-full">
        <!-- Background wavy dashed line -->
        <div class="absolute top-[55px] left-0 w-full h-[60px] z-0 hidden md:block">
            <!-- Left Loop Decorative -->
            <svg class="absolute top-[14px] -left-[24px] w-10 h-10" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M 100,50 C 60,50 30,10 10,30 C -10,50 10,90 40,70 C 70,50 40,30 20,60" stroke="#0AA5C0" stroke-width="5" stroke-dasharray="6 8" stroke-linecap="round" opacity="0.4"/>
            </svg>
            <!-- Right Loop Decorative -->
            <svg class="absolute top-[14px] -right-[24px] w-10 h-10" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M 0,50 C 40,50 70,10 90,30 C 110,50 90,90 60,70 C 30,50 60,30 80,60" stroke="#0AA5C0" stroke-width="5" stroke-dasharray="6 8" stroke-linecap="round" opacity="0.4"/>
            </svg>
            <svg width="100%" height="100%" preserveAspectRatio="none" viewBox="0 0 1000 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M-50,100 Q0,0 100,50 T300,50 T500,50 T700,50 T900,50 T1050,100" stroke="#0AA5C0" stroke-width="2.5" stroke-dasharray="6 8" stroke-linecap="round" vector-effect="non-scaling-stroke" opacity="0.4"/>
            </svg>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-5 gap-10 md:gap-4 relative z-10">
            <!-- Step 1 -->
            <div class="flex flex-col items-center text-center relative">
                <div class="w-[110px] h-[110px] rounded-full bg-gradient-to-br from-[#FFF5ED] to-[#FFE6D1] shadow-[0_8px_20px_rgba(245,138,60,0.15)] flex items-center justify-center mb-6 relative">
                    <!-- Heart Search Icon (Lucide Custom) -->
                    <svg class="w-12 h-12 text-[#F58A3C]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M15.5 3.5a4.5 4.5 0 0 0-6.36 0L8.5 4.14 7.86 3.5a4.5 4.5 0 0 0-6.36 6.36l7 7 7-7a4.5 4.5 0 0 0 0-6.36Z" transform="translate(1, 1)"/>
                        <line x1="21" y1="21" x2="15" y2="15" stroke-width="2.5"/>
                    </svg>
                </div>
                <span class="font-black text-[#F58A3C] text-3xl mb-2">01</span>
                <span class="font-black text-dark text-lg mb-2">Chọn thú cưng</span>
                <p class="text-sm font-bold text-muted leading-tight px-2">Tìm người bạn phù hợp<br>với bạn</p>
            </div>
            
            <!-- Step 2 -->
            <div class="flex flex-col items-center text-center relative">
                <div class="w-[110px] h-[110px] rounded-full bg-gradient-to-br from-[#EAF8FA] to-[#D1F0F5] shadow-[0_8px_20px_rgba(10,165,192,0.15)] flex items-center justify-center mb-6 relative">
                    <!-- Clipboard List (Lucide) -->
                    <svg class="w-12 h-12 text-[#0AA5C0]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect width="8" height="4" x="8" y="2" rx="1" ry="1"/>
                        <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/>
                        <path d="M12 11h4"/><path d="M12 16h4"/><path d="M8 11h.01"/><path d="M8 16h.01"/>
                    </svg>
                </div>
                <span class="font-black text-[#0AA5C0] text-3xl mb-2">02</span>
                <span class="font-black text-dark text-lg mb-2">Gửi đơn nhận nuôi</span>
                <p class="text-sm font-bold text-muted leading-tight px-2">Điền thông tin và gửi<br>đơn đăng ký</p>
            </div>
            
            <!-- Step 3 -->
            <div class="flex flex-col items-center text-center relative">
                <!-- Decorative Top Ring (From Image Design) -->
                <div class="absolute -top-[7px] left-1/2 -translate-x-1/2 w-[124px] h-[124px] rounded-full border border-[#F58A3C]/30 z-0"></div>
                <div class="w-[110px] h-[110px] rounded-full bg-gradient-to-br from-[#FFF5ED] to-[#FFE6D1] shadow-[0_8px_20px_rgba(245,138,60,0.15)] flex items-center justify-center mb-6 relative z-10">
                    <!-- Users/Interview (Lucide) -->
                    <svg class="w-12 h-12 text-[#F58A3C]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                </div>
                <span class="font-black text-[#F58A3C] text-3xl mb-2">03</span>
                <span class="font-black text-dark text-lg mb-2">Phỏng vấn</span>
                <p class="text-sm font-bold text-muted leading-tight px-2">Chúng tôi sẽ liên hệ<br>và phỏng vấn</p>
            </div>
            
            <!-- Step 4 -->
            <div class="flex flex-col items-center text-center relative">
                <div class="w-[110px] h-[110px] rounded-full bg-gradient-to-br from-[#EAF8FA] to-[#D1F0F5] shadow-[0_8px_20px_rgba(10,165,192,0.15)] flex items-center justify-center mb-6 relative">
                    <!-- Clipboard Check (Lucide) -->
                    <svg class="w-12 h-12 text-[#0AA5C0]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect width="8" height="4" x="8" y="2" rx="1" ry="1"/>
                        <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/>
                        <path d="m9 14 2 2 4-4"/>
                    </svg>
                </div>
                <span class="font-black text-[#0AA5C0] text-3xl mb-2">04</span>
                <span class="font-black text-dark text-lg mb-2">Ký hợp đồng</span>
                <p class="text-sm font-bold text-muted leading-tight px-2">Hoàn tất thủ tục và<br>ký hợp đồng nhận nuôi</p>
            </div>
            
            <!-- Step 5 -->
            <div class="col-span-2 md:col-span-1 flex flex-col items-center text-center relative">
                <div class="w-[110px] h-[110px] rounded-full bg-gradient-to-br from-[#FFF5ED] to-[#FFE6D1] shadow-[0_8px_20px_rgba(245,138,60,0.15)] flex items-center justify-center mb-6 relative">
                    <!-- Home with Heart (Lucide Custom) -->
                    <svg class="w-12 h-12 text-[#F58A3C]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                        <path d="M12 17.5l-2.5-2.5a1.5 1.5 0 0 1 2.12-2.12L12 13.5l.38-.38a1.5 1.5 0 0 1 2.12 2.12L12 17.5z"/>
                    </svg>
                </div>
                <span class="font-black text-[#F58A3C] text-3xl mb-2">05</span>
                <span class="font-black text-dark text-lg mb-2">Đón thú cưng</span>
                <p class="text-sm font-bold text-muted leading-tight px-2">Đưa bé về nhà và bắt đầu<br>hành trình mới</p>
            </div>
        </div>
    </div>
</section>

<!-- Volunteer Activities -->
<section class="py-12 lg:py-16 px-6 lg:px-16 max-w-[1400px] mx-auto mt-6 lg:mt-10 bg-cute-pattern">
    <div class="flex justify-center md:justify-between items-center mb-8 text-center md:text-left">
        <h2 class="text-3xl font-extrabold text-[#1D2B53] flex items-center gap-2 tracking-tight">
            Những hoạt động tình nguyện
            <i data-lucide="users" class="w-8 h-8 text-secondary"></i>
        </h2>
        <a href="#" class="text-sm font-bold text-secondary hidden md:flex items-center gap-1 hover:text-emerald-600 transition-colors">
            Xem tất cả hoạt động <i data-lucide="arrow-right" class="w-4 h-4"></i>
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
        <!-- Left Text -->
        <div class="col-span-1 md:col-span-3 flex flex-col items-center text-center md:items-start md:text-left justify-center">
            <h3 class="text-xl font-black text-dark mb-4 leading-snug">Mỗi hành động nhỏ đều tạo nên sự thay đổi lớn</h3>
            <p class="text-sm font-bold text-muted mb-8">Chúng tôi tổ chức nhiều hoạt động cứu hộ, chăm sóc và bảo vệ động vật.</p>
            <a href="#" class="bg-secondary text-white rounded-full font-bold px-6 py-3 text-sm w-max hover:bg-teal-600 transition-colors">Tham gia cùng chúng tôi</a>
        </div>
        
        <!-- Right Masonry Grid -->
        <div class="col-span-1 md:col-span-9 grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Large vertical -->
            <div class="relative rounded-2xl overflow-hidden transform-gpu md:col-span-1 md:row-span-2 group h-[300px] md:h-full">
                <img src="https://images.unsplash.com/photo-1601758177266-bc599de87707?q=80&w=800&auto=format&fit=crop" loading="lazy" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="Volunteer">
                <div class="absolute bottom-4 left-4 right-4 bg-white/95 rounded-full px-4 py-2 text-center shadow-sm">
                    <span class="text-xs font-bold text-dark">Cứu hộ động vật bị bỏ rơi</span>
                </div>
            </div>
            <!-- Small 1 -->
            <div class="relative rounded-2xl overflow-hidden transform-gpu group h-[180px]">
                <img src="https://images.unsplash.com/photo-1516734212186-a967f81ad0d7?q=80&w=600&auto=format&fit=crop" loading="lazy" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="Care">
                <div class="absolute bottom-4 left-4 right-4 bg-white/95 rounded-full px-4 py-2 text-center shadow-sm">
                    <span class="text-xs font-bold text-dark">Chăm sóc & phục hồi sức khỏe</span>
                </div>
            </div>
            <!-- Small 2 -->
            <div class="relative rounded-2xl overflow-hidden transform-gpu group h-[180px]">
                <img src="https://images.unsplash.com/photo-1522276498395-f4f68f7f8454?q=80&w=600&auto=format&fit=crop" loading="lazy" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="Event">
                <div class="absolute bottom-4 left-4 right-4 bg-white/95 rounded-full px-4 py-2 text-center shadow-sm">
                    <span class="text-xs font-bold text-dark">Tổ chức ngày hội nhận nuôi</span>
                </div>
            </div>
            <!-- Small 3 -->
            <div class="relative rounded-2xl overflow-hidden transform-gpu group h-[180px]">
                <img src="https://images.unsplash.com/photo-1533743983669-94fa5c4338ec?q=80&w=600&auto=format&fit=crop" loading="lazy" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="Transport">
                <div class="absolute bottom-4 left-4 right-4 bg-white/95 rounded-full px-4 py-2 text-center shadow-sm">
                    <span class="text-xs font-bold text-dark">Vận chuyển đến mái ấm mới</span>
                </div>
            </div>
            <!-- Small 4 -->
            <div class="relative rounded-2xl overflow-hidden transform-gpu group h-[180px]">
                <img src="https://images.unsplash.com/photo-1516734212186-a967f81ad0d7?q=80&w=600&auto=format&fit=crop" loading="lazy" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="Community">
                <div class="absolute bottom-4 left-4 right-4 bg-white/95 rounded-full px-4 py-2 text-center shadow-sm">
                    <span class="text-xs font-bold text-dark">Lan tỏa yêu thương</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Full Width KPIs Line -->
<section class="py-8 lg:py-12 px-6 lg:px-16 mt-6 lg:mt-10 border-y border-gray-100 bg-white shadow-sm relative z-20">
    <div class="max-w-[1200px] mx-auto flex flex-wrap justify-between gap-6 md:gap-0 items-center divide-x-0 md:divide-x divide-gray-100">
        <div class="flex items-center gap-3 px-4 flex-1 justify-center">
            <div class="w-12 h-12 rounded-full bg-secondary/10 flex items-center justify-center text-secondary text-2xl">👥</div>
            <div class="flex flex-col">
                <span class="text-2xl font-black text-secondary">150+</span>
                <span class="text-[11px] font-bold text-dark uppercase tracking-tight">Tình nguyện viên</span>
            </div>
        </div>
        <div class="flex items-center gap-3 px-4 flex-1 justify-center">
            <div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center text-primary text-2xl">❤️</div>
            <div class="flex flex-col">
                <span class="text-2xl font-black text-primary">500+</span>
                <span class="text-[11px] font-bold text-dark uppercase tracking-tight">Ca cứu hộ thành công</span>
            </div>
        </div>
        <div class="flex items-center gap-3 px-4 flex-1 justify-center">
            <div class="w-12 h-12 rounded-full bg-secondary/10 flex items-center justify-center text-secondary text-2xl">🐾</div>
            <div class="flex flex-col">
                <span class="text-2xl font-black text-secondary">2,300+</span>
                <span class="text-[11px] font-bold text-dark uppercase tracking-tight">Thú cưng được chăm sóc</span>
            </div>
        </div>
        <div class="flex items-center gap-3 px-4 flex-1 justify-center">
            <div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center text-primary text-2xl">🏠</div>
            <div class="flex flex-col">
                <span class="text-2xl font-black text-primary">1,800+</span>
                <span class="text-[11px] font-bold text-dark uppercase tracking-tight">Thú cưng tìm được nhà mới</span>
            </div>
        </div>
        <div class="flex items-center gap-3 px-4 flex-1 justify-center">
            <div class="w-12 h-12 rounded-full bg-secondary/10 flex items-center justify-center text-secondary text-2xl">🤝</div>
            <div class="flex flex-col">
                <span class="text-2xl font-black text-secondary">25+</span>
                <span class="text-[11px] font-bold text-dark uppercase tracking-tight">Đối tác & tổ chức</span>
            </div>
        </div>
    </div>
</section>

<!-- Success Story -->
<section class="py-12 lg:py-20 px-6 lg:px-16 max-w-[1200px] mx-auto mt-6 lg:mt-10 bg-cute-pattern">
    <div class="flex justify-center lg:justify-start items-center mb-10 text-center lg:text-left">
        <h2 class="text-3xl font-extrabold text-[#1D2B53] flex items-center gap-2 tracking-tight">
            Câu chuyện thay đổi cuộc đời
            <i data-lucide="sparkles" class="w-8 h-8 text-primary"></i>
        </h2>
    </div>
    
    <div class="flex flex-col lg:flex-row items-center gap-16 relative">
        <!-- Abstract decorations -->
        <svg class="absolute top-0 right-[30%] w-16 h-16 text-primary z-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
        <svg class="absolute bottom-0 right-[10%] w-12 h-12 text-secondary opacity-50 z-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>

        <!-- Image Slider container -->
        <div class="w-full lg:w-[55%] relative z-10 flex items-center">
            <button class="arrow-button hidden lg:flex absolute -left-5 z-20"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg></button>
            
            <div class="relative w-full h-[350px] rounded-[40px] overflow-hidden flex border-4 border-white shadow-xl">
                <!-- Before -->
                <div class="w-1/2 relative grayscale border-r-2 border-white">
                    <img src="https://images.unsplash.com/photo-1517849845537-4d257902454a?q=80&w=500&auto=format&fit=crop" class="w-full h-full object-cover" alt="Before">
                    <div class="absolute bottom-6 left-6 text-white font-black text-xl tracking-widest">TRƯỚC</div>
                </div>
                <!-- After -->
                <div class="w-1/2 relative border-l-2 border-white">
                    <img src="https://images.unsplash.com/photo-1583511655857-d19b40a7a54e?q=80&w=500&auto=format&fit=crop" class="w-full h-full object-cover" alt="After">
                    <div class="absolute bottom-6 left-6 text-white font-black text-xl tracking-widest">SAU</div>
                </div>
            </div>
            
            <button class="arrow-button hidden lg:flex absolute -right-5 z-20"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></button>
        </div>
        
        <!-- Text Content -->
        <div class="w-full lg:w-[45%] flex flex-col items-center text-center lg:items-start lg:text-left z-10">
            <h3 class="text-3xl font-black text-dark mb-4 leading-tight">Từ bị bỏ rơi đến<br>hạnh phúc viên mãn</h3>
            <p class="text-sm font-bold text-muted mb-8 leading-relaxed">
                Bim được cứu khi đang bị thương nặng và sợ hãi. Sau 3 tháng chăm sóc, Bim đã tìm được gia đình yêu thương và một cuộc sống hạnh phúc.
            </p>
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-secondary/10 flex items-center justify-center text-secondary text-lg">💙</div>
                <span class="font-bold text-dark text-sm">Gia đình anh Nam</span>
            </div>
            
            <!-- Happy family photo collage overlapping slightly -->
            <div class="mt-8 rounded-[40px] overflow-hidden w-[80%] h-40 border-4 border-white shadow-md relative lg:right-[-20%]">
                <img src="https://images.unsplash.com/photo-1583337130417-3346a1be7dee?q=80&w=600&auto=format&fit=crop" class="w-full h-full object-cover" alt="Happy Family">
            </div>
        </div>
    </div>
</section>

<!-- Donation Section (Full Width Beige Background) (Hidden)
<section class="donation-section py-12 lg:py-20 px-6 lg:px-16 w-full mt-10 lg:mt-20 relative overflow-hidden">
    <div class="max-w-[1200px] mx-auto grid grid-cols-1 lg:grid-cols-2 gap-16 relative z-10">
        <div class="flex flex-col items-center text-center lg:items-start lg:text-left justify-center">
            <div class="flex justify-center lg:justify-start items-center mb-4 text-center lg:text-left w-full">
                <h2 class="text-3xl font-extrabold text-[#1D2B53] flex items-center gap-2 tracking-tight">
                    Cùng chúng tôi cứu hộ
                    <i data-lucide="gift" class="w-8 h-8 text-primary"></i>
                </h2>
            </div>
            <p class="text-2xl font-bold text-dark mb-4 leading-tight text-center lg:text-left">Ủng hộ để chúng tôi<br>cứu thêm nhiều sinh mạng</p>
            <p class="text-sm font-bold text-muted mb-8 leading-relaxed border-l-4 border-primary pl-4">
                Sự đóng góp của bạn giúp chúng tôi có thêm nguồn lực<br>để cứu hộ, chăm sóc và tìm mái ấm cho các bé.
            </p>
            <a href="{{ route('frontend.donations.index') }}" class="btn-primary w-max">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path></svg>
                Ủng hộ ngay
            </a>
        </div>
        
        <div class="bg-white/80 backdrop-blur-sm p-8 rounded-[30px] border border-white shadow-soft relative">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-8">
                <button class="py-3 bg-white border border-gray-200 text-dark font-black rounded-xl text-sm shadow-sm">50.000đ</button>
                <button class="py-3 bg-primary border border-primary text-white font-black rounded-xl text-sm shadow-md shadow-orange-500/30">100.000đ</button>
                <button class="py-3 bg-white border border-gray-200 text-dark font-black rounded-xl text-sm shadow-sm">200.000đ</button>
                <button class="py-3 bg-white border border-gray-200 text-dark font-black rounded-xl text-sm shadow-sm">500.000đ</button>
                <button class="py-3 bg-white border border-gray-200 text-dark font-black rounded-xl text-sm shadow-sm md:col-span-4 lg:col-span-1">Khác</button>
            </div>
            
            <div class="mb-2 flex justify-between items-end">
                <span class="text-sm font-bold text-dark">Mục tiêu tháng này</span>
                <span class="text-2xl font-black text-dark">75%</span>
            </div>
            <div class="w-full bg-white rounded-full h-4 mb-3 border border-gray-100 p-0.5">
                <div class="bg-primary h-full rounded-full" style="width: 75%"></div>
            </div>
            <p class="text-xs font-bold text-dark flex items-center gap-1">
                Đã quyên góp: <span class="font-black">37.500.000đ / 50.000.000đ</span>
            </p>
            
            <img src="https://images.unsplash.com/photo-1544568100-847a948585b9?q=80&w=400&auto=format&fit=crop" class="absolute -right-10 -bottom-10 w-48 h-auto object-cover rounded-[30px] border-4 border-white shadow-lg rotate-3" alt="Pets overlay">
        </div>
    </div>
</section>
-->

<!-- News Section -->
<section class="py-12 lg:py-20 px-6 lg:px-16 max-w-[1400px] mx-auto bg-cute-pattern">
    <div class="flex justify-center md:justify-between items-center mb-10 text-center md:text-left">
        <h2 class="text-3xl font-extrabold text-[#1D2B53] flex items-center gap-2 tracking-tight">
            Tin tức mới nhất
            <i data-lucide="newspaper" class="w-8 h-8 text-primary"></i>
        </h2>
        <a href="#" class="text-sm font-bold text-secondary hidden md:flex items-center gap-1 hover:text-emerald-600 transition-colors">
            Xem tất cả <i data-lucide="arrow-right" class="w-4 h-4"></i>
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- News 1 -->
        <a href="#" class="pet-card group p-4 flex flex-col">
            <div class="relative h-40 mb-4 rounded-[16px] overflow-hidden transform-gpu">
                <img src="https://images.unsplash.com/photo-1548199973-03cce0bbc87b?q=80&w=600&auto=format&fit=crop" loading="lazy" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="News">
                <div class="absolute top-3 left-3 bg-white text-primary text-[10px] font-black rounded-full px-3 py-1 shadow-sm uppercase tracking-wider">Chăm sóc thú cưng</div>
            </div>
            <h3 class="text-base font-black text-dark mb-4 leading-tight group-hover:text-primary transition-colors">5 lưu ý khi đưa chó mèo mới về nhà</h3>
            <div class="mt-auto flex items-center justify-between text-xs font-bold text-muted border-t border-gray-50 pt-3">
                <span class="flex items-center gap-1.5"><svg class="w-4 h-4 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> 12/06/2026</span>
                <svg class="w-4 h-4 text-gray-300 group-hover:text-primary transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7-7"></path></svg>
            </div>
        </a>
        <!-- News 2 -->
        <a href="#" class="pet-card group p-4 flex flex-col">
            <div class="relative h-40 mb-4 rounded-[16px] overflow-hidden transform-gpu">
                <img src="https://images.unsplash.com/photo-1522276498395-f4f68f7f8454?q=80&w=600&auto=format&fit=crop" loading="lazy" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="News">
                <div class="absolute top-3 left-3 bg-white text-primary text-[10px] font-black rounded-full px-3 py-1 shadow-sm uppercase tracking-wider">Tin tức</div>
            </div>
            <h3 class="text-base font-black text-dark mb-4 leading-tight group-hover:text-primary transition-colors">Ngày hội nhận nuôi thú cưng tháng 6/2026</h3>
            <div class="mt-auto flex items-center justify-between text-xs font-bold text-muted border-t border-gray-50 pt-3">
                <span class="flex items-center gap-1.5"><svg class="w-4 h-4 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> 09/06/2026</span>
                <svg class="w-4 h-4 text-gray-300 group-hover:text-primary transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7-7"></path></svg>
            </div>
        </a>
        <!-- News 3 -->
        <a href="#" class="pet-card group p-4 flex flex-col">
            <div class="relative h-40 mb-4 rounded-[16px] overflow-hidden transform-gpu">
                <img src="https://images.unsplash.com/photo-1513360371669-4adf3dd7dff8?q=80&w=600&auto=format&fit=crop" loading="lazy" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="News">
                <div class="absolute top-3 left-3 bg-white text-primary text-[10px] font-black rounded-full px-3 py-1 shadow-sm uppercase tracking-wider">Câu chuyện</div>
            </div>
            <h3 class="text-base font-black text-dark mb-4 leading-tight group-hover:text-primary transition-colors">Hành trình giải cứu bé mèo kẹt trong cống</h3>
            <div class="mt-auto flex items-center justify-between text-xs font-bold text-muted border-t border-gray-50 pt-3">
                <span class="flex items-center gap-1.5"><svg class="w-4 h-4 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> 02/06/2026</span>
                <svg class="w-4 h-4 text-gray-300 group-hover:text-primary transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7-7"></path></svg>
            </div>
        </a>
        <!-- News 4 -->
        <a href="#" class="pet-card group p-4 flex flex-col">
            <div class="relative h-40 mb-4 rounded-[16px] overflow-hidden transform-gpu">
                <img src="https://images.unsplash.com/photo-1544568100-847a948585b9?q=80&w=600&auto=format&fit=crop" loading="lazy" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="News">
                <div class="absolute top-3 left-3 bg-white text-primary text-[10px] font-black rounded-full px-3 py-1 shadow-sm uppercase tracking-wider">Hoạt động</div>
            </div>
            <h3 class="text-base font-black text-dark mb-4 leading-tight group-hover:text-primary transition-colors">Chúng tôi đã tổ chức buổi tiêm phòng miễn phí</h3>
            <div class="mt-auto flex items-center justify-between text-xs font-bold text-muted border-t border-gray-50 pt-3">
                <span class="flex items-center gap-1.5"><svg class="w-4 h-4 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> 28/05/2026</span>
                <svg class="w-4 h-4 text-gray-300 group-hover:text-primary transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7-7"></path></svg>
            </div>
        </a>
    </div>
</section>

<!-- FAQ Section -->
<section class="py-12 lg:py-20 px-6 lg:px-16 max-w-[1200px] mx-auto">
    <div class="flex justify-center lg:justify-start items-center mb-12 text-center lg:text-left">
        <h2 class="text-3xl font-extrabold text-[#1D2B53] flex items-center gap-2 tracking-tight">
            Câu hỏi thường gặp
            <i data-lucide="help-circle" class="w-8 h-8 text-secondary"></i>
        </h2>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Accordion List -->
        <div class="lg:col-span-2 flex flex-col gap-3">
            <!-- FAQ 1 -->
            <div x-data="{ open: false }" class="bg-white border border-gray-100 rounded-xl overflow-hidden shadow-sm">
                <button @click="open = !open" class="flex justify-between items-center w-full px-6 py-5 text-left font-black text-dark hover:text-primary transition-colors text-sm">
                    Tôi có cần trả phí khi nhận nuôi không?
                    <svg class="w-5 h-5 transition-transform" :class="open ? 'rotate-180 text-primary' : 'text-gray-400'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                <div x-show="open" class="px-6 pb-5 text-muted text-sm font-bold leading-relaxed border-t border-gray-50 pt-4" style="display: none;">
                    Có, một khoản phí nhỏ được yêu cầu để hỗ trợ chi phí y tế ban đầu như tiêm phòng, tẩy giun và triệt sản.
                </div>
            </div>
            <!-- FAQ 2 -->
            <div x-data="{ open: false }" class="bg-white border border-gray-100 rounded-xl overflow-hidden shadow-sm">
                <button @click="open = !open" class="flex justify-between items-center w-full px-6 py-5 text-left font-black text-dark hover:text-primary transition-colors text-sm">
                    Ai có thể nhận nuôi thú cưng?
                    <svg class="w-5 h-5 transition-transform" :class="open ? 'rotate-180 text-primary' : 'text-gray-400'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                <div x-show="open" class="px-6 pb-5 text-muted text-sm font-bold leading-relaxed border-t border-gray-50 pt-4" style="display: none;">
                    Bất kỳ ai trên 18 tuổi, có nguồn thu nhập ổn định và có khả năng cũng như môi trường sống phù hợp.
                </div>
            </div>
            <!-- FAQ 3 -->
            <div x-data="{ open: false }" class="bg-white border border-gray-100 rounded-xl overflow-hidden shadow-sm">
                <button @click="open = !open" class="flex justify-between items-center w-full px-6 py-5 text-left font-black text-dark hover:text-primary transition-colors text-sm">
                    Thời gian xét duyệt đơn nhận nuôi là bao lâu?
                    <svg class="w-5 h-5 transition-transform" :class="open ? 'rotate-180 text-primary' : 'text-gray-400'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                <div x-show="open" class="px-6 pb-5 text-muted text-sm font-bold leading-relaxed border-t border-gray-50 pt-4" style="display: none;">
                    Thường mất từ 3 đến 5 ngày làm việc để chúng tôi xem xét đơn và sắp xếp phỏng vấn.
                </div>
            </div>
        </div>

        <!-- Contact Box -->
        <div class="lg:col-span-1">
            <div class="bg-secondary rounded-[24px] p-8 h-full text-white flex flex-col justify-center items-center text-center shadow-lg relative overflow-hidden">
                <svg class="absolute -bottom-10 -right-10 w-40 h-40 opacity-10" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/></svg>
                <h3 class="text-lg font-black mb-2">Không tìm thấy câu trả lời?</h3>
                <p class="text-xs font-bold text-white/80 mb-6 leading-relaxed">Liên hệ với chúng tôi để được hỗ trợ trực tiếp nhé!</p>
                <a href="#" class="bg-white text-secondary font-black text-sm px-6 py-3 rounded-full hover:bg-gray-50 transition-colors shadow-sm">Liên hệ ngay</a>
            </div>
        </div>
    </div>
</section>

</div>
@endsection

@section('scripts')
<script>
    // FAQ Accordion functionality handled by Alpine.js
</script>
@endsection
