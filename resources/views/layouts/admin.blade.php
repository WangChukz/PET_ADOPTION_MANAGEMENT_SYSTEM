<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'PETJAM') }} - @yield('title', 'Bảng Điều Khiển')</title>

        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Geist+Mono:wght@400;500;600&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- Chart.js -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        
        <!-- SweetAlert2 -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
    <body class="font-sans antialiased text-slate-900 bg-[#F4F7F6] overflow-hidden">
        
        <!-- Alpine State wrapper for layout -->
        <div x-data="{ expanded: localStorage.getItem('sidebarExpanded') === 'false' ? false : true }" x-init="$watch('expanded', val => localStorage.setItem('sidebarExpanded', val))" class="flex h-screen overflow-hidden">
            
            <!-- Sidebar -->
            @include('layouts.partials.admin-sidebar')

            <!-- Main Content Area -->
            <div class="flex-1 flex flex-col h-screen overflow-hidden relative min-w-0">
                <!-- Mobile Header Overlay (if needed in future) -->
                
                <!-- Top Header -->
                <header class="h-14 border-b border-slate-200 bg-white sticky top-0 z-10 shrink-0 flex items-center justify-between px-6 lg:px-8">
                    <!-- Left side: Breadcrumb -->
                    <div class="flex items-center text-sm font-medium">
                        @if (isset($header))
                            {{ $header }}
                        @else
                            <span class="text-slate-500">Tổng Quan</span>
                            <svg class="w-4 h-4 mx-1 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            <span class="text-orange-brand">Dashboard</span>
                        @endif
                    </div>

                    <!-- Right side: Search & Profile -->
                    <div class="flex items-center gap-5">
                        <!-- Search Bar -->
                        <div class="relative hidden md:block">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>
                            <input type="text" placeholder="Search..." class="w-64 h-9 pl-10 pr-12 bg-slate-50/50 border border-slate-200/80 rounded-full text-sm focus:outline-none focus:border-orange-brand focus:ring-2 focus:ring-orange-brand/20 text-slate-700 placeholder-slate-400 transition-all shadow-sm">
                            <div class="absolute inset-y-0 right-0 pr-2 flex items-center pointer-events-none">
                                <span class="text-[10px] text-slate-400 font-medium border border-slate-200/80 bg-white rounded-full px-1.5 py-0.5 shadow-sm">⌘K</span>
                            </div>
                        </div>

                        <!-- Notification Icon -->
                        <button class="relative w-10 h-10 rounded-full bg-slate-50/50 border border-slate-200/80 flex items-center justify-center text-slate-500 hover:text-orange-brand hover:bg-slate-100 transition-all shadow-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                            <span class="absolute top-2 right-2.5 w-2 h-2 rounded-full bg-red-500 border-2 border-white"></span>
                        </button>

                        <!-- User Avatar -->
                        <button class="w-10 h-10 rounded-full bg-slate-100 border border-slate-200/80 ring-2 ring-transparent hover:ring-orange-brand/20 flex items-center justify-center overflow-hidden shrink-0 transition-all shadow-sm cursor-pointer relative group">
                            <!-- Placeholder image or initial -->
                            <span class="text-sm font-bold text-slate-600 group-hover:text-orange-brand transition-colors">AD</span>
                            <div class="absolute inset-0 rounded-full ring-1 ring-inset ring-black/5"></div>
                        </button>
                    </div>
                </header>

                <!-- Main Scrollable Area -->
                <main class="flex-1 overflow-y-auto p-6 lg:p-8 min-w-0">
                    {{ $slot }}
                </main>
            </div>
        </div>

        <!-- Global Toast Notification System -->
        <div x-data="toastComponent()" 
             x-on:notify.window="add($event.detail)"
             class="fixed flex flex-col gap-3 pointer-events-none w-full"
             style="bottom: 24px; right: 24px; max-width: 350px; z-index: 9999;">
            <template x-for="toast in toasts" :key="toast.id">
                <div x-show="toast.visible"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-8 scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                     x-transition:leave="transition ease-in duration-200"
                     class="pointer-events-auto relative overflow-hidden border shadow-lg p-4 flex items-start gap-3"
                     :class="{
                         'bg-emerald-600 border-emerald-700 text-white': toast.type === 'success',
                         'bg-red-600 border-red-700 text-white': toast.type === 'error',
                         'bg-amber-500 border-amber-600 text-white': toast.type === 'warning',
                         'bg-blue-600 border-blue-700 text-white': toast.type === 'info',
                     }"
                     style="border-radius: 12px;">
                    
                    <!-- Icon -->
                    <div class="shrink-0 rounded-full p-1"
                         :class="{
                             'bg-emerald-700 text-white': toast.type === 'success',
                             'bg-red-700 text-white': toast.type === 'error',
                             'bg-amber-600 text-white': toast.type === 'warning',
                             'bg-blue-700 text-white': toast.type === 'info',
                         }">
                        <svg x-show="toast.type === 'success'" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        <svg x-show="toast.type === 'error'" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        <svg x-show="toast.type === 'warning'" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        <svg x-show="toast.type === 'info'" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>

                    <!-- Message -->
                    <div class="flex-1 pt-0.5">
                        <p class="text-sm font-medium leading-snug" x-text="toast.message"></p>
                    </div>

                    <!-- Undo Button -->
                    <button type="button" x-show="toast.undoable" @click="undoAction(toast)" class="shrink-0 text-sm font-bold underline hover:opacity-80 transition-opacity whitespace-nowrap bg-black/20 px-2 py-0.5 rounded">
                        Hoàn tác
                    </button>

                    <!-- Close Button -->
                    <button type="button" @click="remove(toast.id)" class="shrink-0 opacity-70 hover:opacity-100 transition-opacity p-1 -m-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>

                    <!-- Progress Bar -->
                    <div class="absolute bottom-0 left-0 h-1 bg-black/20 w-full">
                        <div class="h-full transition-all duration-75 ease-linear bg-white/80"
                             :style="`width: ${toast.progress}%`"></div>
                    </div>
                </div>
            </template>
        </div>

        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('toastComponent', () => ({
                    toasts: [],
                    add(toast) {
                        const id = Date.now();
                        const newToast = {
                            id,
                            type: toast.type || 'info',
                            message: toast.message,
                            undoable: toast.undoable || false,
                            slotId: toast.slotId || null,
                            visible: true,
                            progress: 100,
                        };
                        this.toasts.push(newToast);

                        const duration = toast.undoable ? 5000 : 3000;
                        const interval = 20;
                        const step = (100 / (duration / interval));
                        
                        const timer = setInterval(() => {
                            const t = this.toasts.find(t => t.id === id);
                            if (t && t.progress > 0) {
                                t.progress -= step;
                            } else {
                                clearInterval(timer);
                            }
                        }, interval);

                        setTimeout(() => {
                            this.remove(id);
                        }, duration);
                    },
                    remove(id) {
                        const toast = this.toasts.find(t => t.id === id);
                        if (toast) {
                            toast.visible = false;
                            setTimeout(() => {
                                this.toasts = this.toasts.filter(t => t.id !== id);
                            }, 300);
                        }
                    },
                    undoAction(toast) {
                        window.dispatchEvent(new CustomEvent('undo-action', { detail: toast.slotId }));
                        this.remove(toast.id);
                    }
                }));
            });
        </script>

        <!-- Auto trigger Laravel Sessions -->
        @if(session('success'))
            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    setTimeout(() => { window.dispatchEvent(new CustomEvent('notify', { detail: { type: 'success', message: `{!! addslashes(session('success')) !!}` }})); }, 100);
                });
            </script>
        @endif
        @if(session('error'))
            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    setTimeout(() => { window.dispatchEvent(new CustomEvent('notify', { detail: { type: 'error', message: `{!! addslashes(session('error')) !!}` }})); }, 100);
                });
            </script>
        @endif

        <script>
            // Global AJAX Table Initializer
            window.initAjaxTable = function(containerId, formId = null) {
                const container = document.getElementById(containerId);
                const form = formId ? document.getElementById(formId) : null;
                
                if (!container) return;

                let debounceTimer;

                async function fetchAndReplace(url) {
                    const overlay = document.getElementById('table-loading-overlay');
                    if(overlay) overlay.classList.remove('hidden');

                    try {
                        const response = await fetch(url, {
                            headers: { 'X-Requested-With': 'XMLHttpRequest' }
                        });
                        if (response.ok) {
                            const html = await response.text();
                            const parser = new DOMParser();
                            const doc = parser.parseFromString(html, 'text/html');
                            
                            const newContainer = doc.getElementById(containerId);
                            if (newContainer) {
                                container.innerHTML = newContainer.innerHTML;
                                window.history.pushState({}, '', url);
                            }
                        }
                    } catch (error) {
                        console.error('Lỗi khi tải dữ liệu:', error);
                        // Fallback
                        window.location.href = url;
                    } finally {
                        const newOverlay = document.getElementById('table-loading-overlay');
                        if(newOverlay) newOverlay.classList.add('hidden');
                    }
                }

                // Intercept pagination clicks
                container.addEventListener('click', (e) => {
                    const link = e.target.closest('a');
                    if (link && link.href && link.closest('nav[aria-label="Pagination"]')) {
                        e.preventDefault();
                        fetchAndReplace(link.href);
                    }
                });

                // Intercept per_page select change inside table container
                container.addEventListener('change', (e) => {
                    if (e.target.name === 'per_page') {
                        e.preventDefault();
                        const url = new URL(window.location.href);
                        url.searchParams.set('per_page', e.target.value);
                        url.searchParams.set('page', '1');
                        fetchAndReplace(url.toString());
                    }
                });

                // Handle Form Filters
                if (form) {
                    const submitForm = () => {
                        const formData = new FormData(form);
                        const url = new URL(form.action || window.location.href);
                        
                        // Preserve per_page if it exists in current url
                        const currentParams = new URLSearchParams(window.location.search);
                        if(currentParams.has('per_page')) {
                            url.searchParams.set('per_page', currentParams.get('per_page'));
                        }

                        // Add form data to url params
                        for (const [key, value] of formData.entries()) {
                            if (value && value !== 'all') {
                                url.searchParams.set(key, value);
                            } else {
                                url.searchParams.delete(key);
                            }
                        }
                        url.searchParams.delete('page'); // reset page to 1
                        
                        fetchAndReplace(url.toString());
                    };

                    form.addEventListener('submit', (e) => {
                        e.preventDefault();
                        submitForm();
                    });

                    // Auto submit on select change
                    form.addEventListener('change', (e) => {
                        if (e.target.tagName === 'SELECT') {
                            submitForm();
                        }
                    });

                    // Auto submit on input (debounce)
                    form.addEventListener('input', (e) => {
                        if (e.target.tagName === 'INPUT' && e.target.type === 'text') {
                            clearTimeout(debounceTimer);
                            debounceTimer = setTimeout(() => {
                                submitForm();
                            }, 300); // 0.3s delay to prevent request overlap
                        }
                    });
                }
            };
        </script>

        @stack('scripts')
        
        @if (auth()->check() && !request()->routeIs('login', 'register'))
    @include('components.chatbox-widget')
@endif
    </body>
</html>
