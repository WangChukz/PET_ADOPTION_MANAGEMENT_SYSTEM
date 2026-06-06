<div x-data="petjamChatbox" class="fixed bottom-6 right-6 z-50 flex flex-col items-end">

    <!-- KHUNG CHATBOX -->
    <div x-show="isOpen" 
         x-transition:enter="transition ease-out duration-300 transform"
         x-transition:enter-start="opacity-0 translate-y-8 scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-200 transform"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 translate-y-8 scale-95"
         class="w-[360px] h-[530px] bg-white rounded-2xl shadow-2xl flex flex-col border border-slate-100 overflow-hidden mb-4"
         style="display: none;">
         
        <!-- HEADER -->
        <div class="bg-[#267D8F] px-4 py-3 flex items-center justify-between text-white shadow-md shrink-0">
            <div class="flex items-center gap-2.5">
                <!-- Avatar PetAdoption -->
                <div class="w-9 h-9 rounded-full bg-[#E06B25] flex items-center justify-center shadow-sm shrink-0">
                    <svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 14c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3zm-4.5-2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm9 0c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm-6.75-5C8.89 7 8 7.89 8 9s.89 2 2 2 2-.89 2-2-.89-2-2-2zm4.5 0c-.89 0-1.75.89-1.75 2s.86 2 1.75 2 1.75-.89 1.75-2-.86-2-1.75-2z"/>
                    </svg>
                </div>
                <div class="flex flex-col">
                    <span class="font-semibold text-[15px] leading-tight">PetAdoption Support</span>
                    <span class="text-xs text-teal-100/90 flex items-center gap-1.5 mt-0.5">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 inline-block animate-pulse"></span>
                        Đang hoạt động
                    </span>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <button @click="toggleChatbox()" class="text-teal-100 hover:text-white transition-colors cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        </div>

        <!-- LỊCH SỬ CHAT -->
        <div x-ref="chatArea" class="flex-1 overflow-y-auto p-4 bg-slate-50/50 space-y-4 text-sm scroll-smooth">
            <div class="text-center my-2 text-[11px] text-slate-400 font-medium tracking-wide">Hôm nay</div>

            <template x-for="(msg, index) in messages" :key="index">
                <div>
                    <!-- Tin nhắn của Bot -->
                    <div x-show="msg.sender === 'bot'" class="flex items-start gap-2 max-w-[85%]" style="display: none;">
                        <!-- Avatar Bot -->
                        <div class="w-8 h-8 rounded-full bg-[#E06B25] flex items-center justify-center shrink-0 shadow-sm mt-0.5">
                            <svg class="w-4 h-4 text-white" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 14c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3zm-4.5-2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm9 0c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm-6.75-5C8.89 7 8 7.89 8 9s.89 2 2 2 2-.89 2-2-.89-2-2-2zm4.5 0c-.89 0-1.75.89-1.75 2s.86 2 1.75 2 1.75-.89 1.75-2-.86-2-1.75-2z"/>
                            </svg>
                        </div>
                        <div class="flex flex-col gap-1">
                            <!-- Hiển thị HTML sau khi dịch Markdown -->
                            <div class="bg-white border border-slate-100 rounded-2xl rounded-tl-none px-4 py-2.5 shadow-sm text-slate-800 leading-relaxed" x-html="renderMarkdown(msg.text)"></div>
                            
                            <!-- Nút chuyển hướng nếu có redirect -->
                            <template x-if="msg.redirect">
                                <div class="mt-1.5 pl-1">
                                    <button @click="handleRedirect(msg.redirect)" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-[#267D8F] text-white text-xs font-bold rounded-xl hover:bg-teal-700 active:scale-95 transition-all shadow cursor-pointer">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                        </svg>
                                        Đi Tới Trang Liên Quan
                                    </button>
                                </div>
                            </template>

                            <span class="text-[10px] text-slate-400 px-1 mt-0.5" x-text="msg.time"></span>
                            
                            <!-- Nút Đăng nhập dành cho khách -->
                            <template x-if="isGuest && index === 0">
                                <div class="mt-2 pl-1">
                                    <a href="{{ route('login') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-[#DF6B1E] text-white text-xs font-bold rounded-xl shadow hover:bg-orange-600 transition-all active:scale-95">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                                        </svg>
                                        Đăng Nhập Ngay
                                    </a>
                                </div>
                            </template>
                        </div>
                    </div>

                    <!-- Tin nhắn của User -->
                    <div x-show="msg.sender === 'user'" class="flex flex-col items-end gap-1 ml-auto max-w-[85%]" style="display: none;">
                        <div class="flex flex-col gap-1.5 items-end">
                            <template x-if="msg.image">
                                <img :src="msg.image" class="max-w-xs rounded-xl shadow-sm border border-slate-200/80 object-cover max-h-40" />
                            </template>
                            <div x-show="msg.text" class="bg-[#E2EEF1] text-slate-800 rounded-2xl rounded-tr-none px-4 py-2.5 shadow-sm leading-relaxed" x-text="msg.text"></div>
                        </div>
                        <span class="text-[10px] text-slate-400 flex items-center gap-1.5 px-1">
                            <span x-text="msg.time"></span>
                            <span class="text-sky-500 font-bold">✔✔</span>
                        </span>
                    </div>
                </div>
            </template>

            <!-- Loading Indicator -->
            <div x-show="isLoading" class="flex items-start gap-2 max-w-[85%]" style="display: none;">
                <div class="w-8 h-8 rounded-full bg-[#E06B25] flex items-center justify-center shrink-0 shadow-sm mt-0.5">
                    <svg class="w-4 h-4 text-white" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 14c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3zm-4.5-2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm9 0c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm-6.75-5C8.89 7 8 7.89 8 9s.89 2 2 2 2-.89 2-2-.89-2-2-2zm4.5 0c-.89 0-1.75.89-1.75 2s.86 2 1.75 2 1.75-.89 1.75-2-.86-2-1.75-2z"/>
                    </svg>
                </div>
                <div class="bg-white border border-slate-100 rounded-2xl rounded-tl-none px-4 py-3 shadow-sm flex items-center gap-1.5">
                    <span class="w-2.5 h-2.5 rounded-full bg-slate-400 animate-bounce" style="animation-delay: 0.1s"></span>
                    <span class="w-2.5 h-2.5 rounded-full bg-slate-400 animate-bounce" style="animation-delay: 0.2s"></span>
                    <span class="w-2.5 h-2.5 rounded-full bg-slate-400 animate-bounce" style="animation-delay: 0.3s"></span>
                </div>
            </div>
        </div>

        <!-- FOOTER & INPUT -->
        <div class="p-3 bg-white border-t border-slate-100 shrink-0">
            <!-- Xem trước ảnh đính kèm -->
            <div x-show="imagePreview" class="relative inline-block mb-2 p-1 bg-slate-100 border border-slate-200 rounded-xl" style="display: none;">
                <img :src="imagePreview" class="h-14 w-14 object-cover rounded-lg" />
                <button @click="removeImage" class="absolute -top-1.5 -right-1.5 bg-rose-500 text-white rounded-full p-0.5 hover:bg-rose-600 transition-colors shadow shadow-rose-950/20">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <!-- Hộp nhập tin nhắn bo tròn -->
            <div class="flex items-center gap-2">
                <div class="flex-1 flex items-center border border-slate-200 rounded-full px-4 py-1.5 bg-slate-50/50 focus-within:border-teal-500 focus-within:bg-white focus-within:ring-1 focus-within:ring-teal-500 transition-all">
                    <input type="text" 
                           x-model="inputMessage" 
                           @keydown.enter="sendMessage" 
                           :placeholder="isGuest ? 'Vui lòng đăng nhập để chat...' : 'Nhập tin nhắn...'" 
                           :disabled="isGuest"
                           class="flex-1 bg-transparent border-none outline-none focus:ring-0 p-0 text-slate-700 text-sm placeholder-slate-400 disabled:opacity-60">
                    
                    <!-- File input ẩn -->
                    <input type="file" x-ref="fileInput" @change="handleFileChange" class="hidden" accept="image/jpeg,image/png,image/jpg">

                    <!-- Attachment Button -->
                    <div class="flex items-center gap-2 text-slate-400 shrink-0 ml-2">
                        <button type="button" @click="triggerFileInput" :disabled="isGuest" class="hover:text-slate-650 transition-colors cursor-pointer disabled:opacity-30 disabled:pointer-events-none">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                        </button>
                    </div>
                </div>

                <!-- Nút gửi màu cam -->
                <button type="button" 
                        @click="sendMessage" 
                        :disabled="isGuest"
                        class="w-9 h-9 rounded-full bg-[#DF6B1E] flex items-center justify-center text-white shadow hover:bg-orange-600 active:scale-95 transition-all shrink-0 cursor-pointer disabled:bg-slate-300 disabled:shadow-none disabled:pointer-events-none">
                    <svg class="w-4.5 h-4.5 transform rotate-45 translate-x-[-1px] translate-y-[1px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- ICON CHATBOX NỔI (Style Avatar bé cún có tooltip khi hover) -->
    <div class="relative flex flex-col items-center group cursor-pointer" @click="toggleChatbox()">
        <!-- Tooltip khi hover (ở bên trái) -->
        <div class="absolute right-16 bottom-2 w-72 bg-white text-slate-800 rounded-2xl shadow-xl border border-slate-100 p-3.5 pointer-events-none opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-50 flex gap-2.5 items-start">
            <img src="{{ asset('images/ai-advisor.png') }}" class="w-8 h-8 rounded-full object-cover border border-slate-100" />
            <div class="flex flex-col text-[11px] leading-normal text-left">
                <span class="font-bold text-[#E06B25] mb-0.5">Xin chào!</span>
                <span class="text-slate-600">Mình là trợ lý AI của <span class="font-bold text-teal-600">PetAdoption</span>. Bạn cần hỗ trợ gì hôm nay?</span>
            </div>
            <!-- Mũi tên chỉ sang phải -->
            <div class="absolute top-1/2 -translate-y-1/2 -right-1.5 w-3 h-3 bg-white rotate-45 border-r border-t border-slate-100"></div>
        </div>

        <!-- Avatar cún cưng tròn -->
        <div class="relative w-16 h-16 rounded-full bg-teal-50 border-2 border-teal-650/20 shadow-xl overflow-visible hover:scale-105 active:scale-95 transition-transform flex items-center justify-center">
            <img src="{{ asset('images/ai-advisor.png') }}" class="w-full h-full rounded-full object-cover" />
            
            <!-- Badge đỏ đếm tin chưa đọc -->
            <span x-show="unreadCount > 0" 
                  x-text="unreadCount" 
                  class="absolute -top-1 -right-1 bg-red-500 text-[10px] font-bold text-white h-5 w-5 rounded-full flex items-center justify-center border-2 border-white shadow"></span>
        </div>
        
        <!-- Nhãn "Tư vấn AI" -->
        <span class="mt-1.5 px-3 py-0.5 bg-white text-[10px] font-bold text-teal-800 rounded-full border border-teal-600/20 shadow-sm whitespace-nowrap">Tư vấn AI</span>
    </div>

</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('petjamChatbox', () => ({
            isOpen: false,
            messages: [],
            isLoading: false,
            inputMessage: '',
            imagePreview: null,
            unreadCount: 0,
            isGuest: {{ Auth::check() ? 'false' : 'true' }},
            userId: '{{ Auth::id() }}',
            storageKey: 'petjam_chat_messages_{{ Auth::id() }}',

            init() {
                // Check if page was reloaded (F5)
                const navEntries = performance.getEntriesByType('navigation');
                const isReload = navEntries.length > 0 && navEntries[0].type === 'reload';

                if (isReload) {
                    sessionStorage.removeItem(this.storageKey);
                }

                // Load messages from sessionStorage
                const saved = sessionStorage.getItem(this.storageKey);
                if (saved) {
                    this.messages = JSON.parse(saved);
                } else {
                    const welcomeTime = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                    this.messages = [
                        {
                            sender: 'bot',
                            text: 'Xin chào! Mình là trợ lý AI của PetAdoption. Bạn cần hỗ trợ gì hôm nay?',
                            time: welcomeTime,
                            redirect: null
                        }
                    ];
                    this.saveMessages();
                }
            },

            toggleChatbox() {
                this.isOpen = !this.isOpen;
                if (this.isOpen) {
                    this.unreadCount = 0;
                    this.$nextTick(() => {
                        const chatArea = this.$refs.chatArea;
                        if (chatArea) chatArea.scrollTop = chatArea.scrollHeight;
                    });
                }
            },

            triggerFileInput() {
                if (this.isGuest) return;
                this.$refs.fileInput.click();
            },

            handleFileChange(event) {
                const file = event.target.files[0];
                if (!file) return;

                if (!file.type.match('image.*')) {
                    alert('Vui lòng chọn file hình ảnh (jpg, jpeg, png).');
                    return;
                }

                if (file.size > 2 * 1024 * 1024) {
                    alert('Kích thước ảnh tối đa là 2MB.');
                    return;
                }

                const reader = new FileReader();
                reader.onload = (e) => {
                    this.imagePreview = e.target.result;
                };
                reader.readAsDataURL(file);
            },

            removeImage() {
                this.imagePreview = null;
                this.$refs.fileInput.value = '';
            },

            async sendMessage() {
                if (this.isGuest) return;

                const text = this.inputMessage.trim();
                const image = this.imagePreview;

                if (!text && !image) return;

                const time = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

                // Add user message
                this.messages.push({
                    sender: 'user',
                    text: text,
                    image: image,
                    time: time
                });

                // Clear inputs
                this.inputMessage = '';
                const fileForUpload = this.$refs.fileInput.files[0];
                this.removeImage();

                this.saveMessages();

                this.$nextTick(() => {
                    const chatArea = this.$refs.chatArea;
                    if (chatArea) chatArea.scrollTop = chatArea.scrollHeight;
                });

                this.isLoading = true;

                // Prepare request
                const formData = new FormData();
                formData.append('message', text);
                if (fileForUpload) {
                    formData.append('image', fileForUpload);
                }

                try {
                    const csrfToken = '{{ csrf_token() }}';
                    const response = await fetch('{{ route('chatbox.message') }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken || '',
                            'Accept': 'application/json'
                        },
                        body: formData
                    });

                    if (response.status === 401) {
                        const data = await response.json();
                        const botTime = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                        this.messages.push({
                            sender: 'bot',
                            text: data.message || 'Vui lòng đăng nhập để tiếp tục chat.',
                            time: botTime,
                            redirect: '{{ route('login') }}'
                        });
                    } else if (!response.ok) {
                        throw new Error('Server Error');
                    } else {
                        const data = await response.json();
                        const botTime = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                        this.messages.push({
                            sender: 'bot',
                            text: data.message || '',
                            time: botTime,
                            redirect: data.redirect_url || null
                        });
                    }
                } catch (error) {
                    console.error('Chat error:', error);
                    const errorTime = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                    this.messages.push({
                        sender: 'bot',
                        text: 'Mất kết nối. Vui lòng thử lại sau ít phút!',
                        time: errorTime
                    });
                } finally {
                    this.isLoading = false;
                    if (!this.isOpen) {
                        this.unreadCount++;
                    }
                    this.saveMessages();
                    this.$nextTick(() => {
                        const chatArea = this.$refs.chatArea;
                        if (chatArea) chatArea.scrollTop = chatArea.scrollHeight;
                    });
                }
            },

            saveMessages() {
                sessionStorage.setItem(this.storageKey, JSON.stringify(this.messages));
            },

            renderMarkdown(text) {
                if (!text) return '';
                // Basic markdown rendering to handle bold, links, list, and line breaks
                let html = text
                    .replace(/&/g, '&amp;')
                    .replace(/</g, '&lt;')
                    .replace(/>/g, '&gt;');
                
                // Bold **text**
                html = html.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');
                // Italic *text*
                html = html.replace(/\*(.*?)\*/g, '<em>$1</em>');
                // Relative markdown links e.g. [nhận nuôi](/nhan-nuoi)
                html = html.replace(/\[(.*?)\]\((.*?)\)/g, (match, linkText, urlPath) => {
                    let finalUrl = urlPath;
                    if (urlPath.startsWith('/')) {
                        finalUrl = '{{ url('/') }}' + urlPath;
                    }
                    return `<a href="${finalUrl}" class="text-sky-600 hover:underline font-medium">${linkText}</a>`;
                });
                // Lists starting with - or *
                html = html.replace(/^\s*[-*]\s+(.*)$/gm, '<li>$1</li>');
                html = html.replace(/(<li>.*<\/li>)/s, '<ul>$1</ul>');
                // Newlines to br
                html = html.replace(/\n/g, '<br>');
                return html;
            },

            handleRedirect(url) {
                if (url) {
                    let finalUrl = url;
                    if (url.startsWith('/')) {
                        finalUrl = '{{ url('/') }}' + url;
                    }
                    window.location.href = finalUrl;
                }
            }
        }));
    });
</script>
