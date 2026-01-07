<header class="bg-white font-sans shadow-sm sticky top-0 z-50">
    {{-- 1. TOP BAR --}}
    <div class="bg-slate-900 text-slate-300 text-xs py-2">
        <div class="container mx-auto px-4 flex justify-between items-center">
            <div class="hidden md:flex items-center gap-4">
                <span>{{ now()->locale('vi')->translatedFormat('l, d/m/Y') }}</span>
                <span class="w-px h-3 bg-slate-700"></span>
                <span>Nghệ An, Việt Nam</span>
            </div>
            
            <div class="flex items-center gap-4 ml-auto md:ml-0">
                {{-- Music Player Button --}}
                <button id="music-toggle" onclick="openMusicPlayer()" class="flex items-center gap-1 hover:text-white transition-colors cursor-pointer" title="Mở trình phát nhạc">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                    </svg>
                    <span class="text-xs uppercase font-bold hidden sm:inline">Nhạc</span>
                </button>
                <span class="w-px h-3 bg-slate-700"></span>

                @guest
                    {{-- Sử dụng onclick để mở Modal thay vì gọi route('login') gây lỗi --}}
                    <button onclick="openAuth('LOGIN')" class="hover:text-white transition-colors uppercase font-bold cursor-pointer">Đăng nhập</button>
                    <span class="w-px h-3 bg-slate-700"></span>
                    <button onclick="openAuth('REGISTER')" class="hover:text-white transition-colors uppercase font-bold cursor-pointer">Đăng ký</button>
                @else
                    <div class="flex items-center gap-2">
                        <span class="text-white font-bold">Hi, {{ Auth::user()->name }}</span>
                        @if(Auth::user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="text-yellow-500 hover:text-yellow-400 text-[10px] uppercase border border-yellow-600 px-1 rounded">Admin</a>
                        @endif
                    </div>
                    {{-- Kiểm tra route logout có tồn tại không trước khi render form --}}
                    <form action="{{ Route::has('logout') ? route('logout') : '#' }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="hover:text-red-500 transition-colors ml-2">Thoát</button>
                    </form>
                @endguest
            </div>
        </div>
    </div>

    {{-- 2. MAIN HEADER (Logo & Search) --}}
    <div class="container mx-auto px-4 py-6 border-b border-gray-100">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                <div class="w-12 h-12 flex items-center justify-center rounded shadow-sm group-hover:bg-slate-900 transition-colors duration-300 overflow-hidden">
    <img src="img/logo.png" alt="Logo" class="w-full h-full object-contain">
</div>
                <div class="flex flex-col">
                    <span class="text-2xl font-black uppercase tracking-widest text-slate-900 leading-none group-hover:text-red-800 transition-colors duration-300">
                       TIỂU ĐOÀN 15
                    </span>
                    <span class="text-xs text-slate-500 font-bold tracking-wider uppercase mt-1">
                        Tin tức Quân sự - Quốc phòng
                    </span>
                </div>
            </a>

            <div class="hidden md:block w-1/3">
                <form action="{{ route('search') }}" method="GET" class="relative">
                    <input type="text" name="q" placeholder="Tìm kiếm tin tức..." class="w-full pl-4 pr-10 py-2 bg-gray-50 border border-gray-200 rounded text-sm focus:outline-none focus:border-red-800 focus:ring-1 focus:ring-red-800 transition-all" value="{{ request('q') }}">
                    <button type="submit" class="absolute right-0 top-0 h-full px-3 text-gray-400 hover:text-red-800">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>

{{-- 3. NAVIGATION MENU --}}
<nav class="bg-[#880000] shadow-md">
    <div class="container mx-auto px-4">

        @php
            $navItems = [
                ['name' => 'Trang chủ', 'url' => route('home')], 
                ['name' => 'Lịch sử phát triển', 'url' => route('lich-su')], 
                ['name' => 'Sách sử', 'url' => route('sach-su')],
                ['name' => 'Thi nhận thức', 'url' => route('thi')],
            ];
        @endphp

        {{-- Mobile Header --}}
        <div class="md:hidden flex justify-between items-center py-3">
            <span class="font-bold uppercase tracking-widest text-white">
                Danh mục
            </span>
            <div class="flex items-center gap-2">
                {{-- Mobile Search Button --}}
                <button
                    onclick="document.getElementById('mobile-search').classList.toggle('hidden')"
                    class="text-white hover:text-red-300 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
                {{-- Mobile Menu Button --}}
                <button
                    onclick="document.getElementById('mobile-menu').classList.toggle('hidden')"
                    class="text-white focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>

        {{-- Mobile Search Form --}}
        <div id="mobile-search" class="hidden md:hidden px-5 pb-3">
            <form action="{{ route('search') }}" method="GET" class="relative">
                <input type="text" name="q" placeholder="Tìm kiếm tin tức..." class="w-full pl-4 pr-10 py-2 bg-white border border-red-300 rounded text-sm focus:outline-none focus:border-red-800 focus:ring-1 focus:ring-red-800 transition-all" value="{{ request('q') }}">
                <button type="submit" class="absolute right-0 top-0 h-full px-3 text-gray-400 hover:text-red-800">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
            </form>
        </div>

        {{-- Desktop Menu --}}
        <ul class="hidden md:flex items-center">
            @foreach($navItems as $item)
                <li>
                    <a href="{{ $item['url'] }}"
                       class="group relative block px-6 py-4 text-sm font-bold uppercase tracking-widest text-white transition-all hover:bg-red-900">
                        {{ $item['name'] }}
                        <span
                            class="absolute bottom-2 left-6 right-6 h-0.5 bg-white scale-x-0 group-hover:scale-x-100 transition-transform origin-left duration-300">
                        </span>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>

    {{-- Mobile Menu --}}
    <div id="mobile-menu" class="hidden md:hidden bg-[#880000] border-t border-red-900">
        <ul class="flex flex-col">
            @foreach($navItems as $item)
                <li>
                    <a href="{{ $item['url'] }}"
                       class="block px-5 py-4 text-sm font-bold uppercase tracking-widest text-white border-b border-red-900 hover:bg-red-900 transition-colors">
                        {{ $item['name'] }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</nav>

{{-- MUSIC PLAYER MODAL --}}
<div id="music-player-modal" class="fixed inset-0 z-[100] hidden flex items-center justify-center p-4 bg-slate-900/95 backdrop-blur-sm">
    <div class="relative w-full max-w-2xl bg-white shadow-2xl overflow-hidden min-h-[600px] rounded-sm">

        {{-- Close Button --}}
        <button onclick="closeMusicPlayer()" class="absolute top-4 right-4 z-10 text-gray-400 hover:text-military-red">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="square" stroke-linejoin="miter" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>

        {{-- Header --}}
        <div class="bg-military-red text-white p-6">
            <h2 class="text-2xl font-serif font-bold uppercase tracking-wider text-center">
                🎵 TRÌNH PHÁT NHẠC QUÂN ĐỘI
            </h2>
            <p class="text-center text-sm mt-2 opacity-90">15 Bài Hát Chủ Đề Quân Sự - Quốc Phòng</p>
        </div>

        {{-- Main Content --}}
        <div class="flex flex-col md:flex-row h-[500px]">

            {{-- Left Side: Now Playing --}}
            <div class="md:w-1/2 p-6 bg-slate-50 flex flex-col justify-center items-center">
                {{-- YouTube Player Embed --}}
                <div class="w-full max-w-sm mb-6">
                    <div id="youtube-player" class="aspect-video bg-black rounded-lg overflow-hidden shadow-lg">
                        <!-- YouTube iframe will be inserted here by YouTube API -->
                    </div>
                </div>

                <div class="text-center mb-4">
                    <h3 id="current-song-title" class="text-xl font-serif font-bold text-gray-900 mb-1">Quốc tế ca</h3>
                    <p id="current-song-artist" class="text-sm text-military-red font-medium">Nhạc Cách Mạng</p>
                    <p id="current-song-category" class="text-xs text-gray-500 mt-1">Quốc Tế</p>
                </div>

                {{-- Controls --}}
                <div class="flex items-center gap-4 mb-4">
                    <button id="prev-btn" onclick="playPrevious()" class="p-3 text-military-red hover:text-white hover:bg-military-red rounded-full transition-colors" title="Bài trước">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </button>

                    <button id="play-pause-btn" onclick="togglePlayPause()" class="p-4 bg-military-red text-white rounded-full hover:bg-red-800 transition-colors shadow-lg">
                        <svg id="play-icon" class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M8 5v14l11-7z"/>
                        </svg>
                        <svg id="pause-icon" class="w-8 h-8 hidden" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/>
                        </svg>
                    </button>

                    <button id="next-btn" onclick="playNext()" class="p-3 text-military-red hover:text-white hover:bg-military-red rounded-full transition-colors" title="Bài tiếp">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>
                </div>

                {{-- Song Counter --}}
                <div class="text-center text-sm text-gray-600">
                    <span id="current-song-number">1</span> / 15 bài hát
                </div>
            </div>

            {{-- Right Side: Playlist --}}
            <div class="md:w-1/2 p-6 bg-white border-l border-gray-100">
                <h3 class="text-lg font-serif font-bold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-military-red" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    DANH SÁCH PHÁT (15 BÀI)
                </h3>

                <div class="space-y-2 max-h-80 overflow-y-auto">
                    {{-- Song List will be populated by JavaScript --}}
                </div>
            </div>
        </div>
    </div>
</div>

</header>

{{-- AUTH MODAL --}}
<div id="auth-modal" class="fixed inset-0 z-[100] hidden flex items-center justify-center p-4 bg-slate-900/90 backdrop-blur-sm">
    <div class="relative w-full max-w-4xl bg-white shadow-2xl flex overflow-hidden min-h-[600px] rounded-sm">
        
        <button onclick="closeAuth()" class="absolute top-4 right-4 z-10 text-gray-400 hover:text-military-red">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="square" strokeLinejoin="miter" strokeWidth="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>

        {{-- Left Side: Image --}}
        <div class="hidden md:block w-1/2 bg-slate-800 relative">
            <img src="{{ asset('img/banner web.jpg') }}" class="absolute inset-0 w-full h-full object-cover opacity-60 mix-blend-overlay" />
            <div class="absolute inset-0 bg-gradient-to-t from-military-red/80 to-slate-900/60 flex flex-col justify-end p-12 text-white">
              <h2 class="text-4xl font-serif font-black uppercase mb-4 leading-none">Phát Huy<br/>Truyền Thống</h2>
<p class="text-sm text-gray-200 font-light opacity-80">
    Tìm hiểu lịch sử vẻ vang, trau dồi bản lĩnh chính trị và cập nhật kịp thời các hoạt động huấn luyện, sẵn sàng chiến đấu của đơn vị.
</p>
            </div>
        </div>

        {{-- Right Side: Form --}}
        <div class="w-full md:w-1/2 p-12 flex flex-col justify-center bg-white relative">
            
            <div class="flex border-b border-gray-200 mb-6">
                <button id="login-tab" onclick="setAuthMode('LOGIN')" class="flex-1 pb-4 text-center text-xs font-bold uppercase tracking-widest transition-colors text-military-red border-b-2 border-military-red">
                    Đăng Nhập
                </button>
                <button id="register-tab" onclick="setAuthMode('REGISTER')" class="flex-1 pb-4 text-center text-xs font-bold uppercase tracking-widest transition-colors text-gray-400 hover:text-gray-600">
                    Đăng Ký
                </button>
            </div>

            {{-- Social Login Buttons --}}
            <div class="mb-6">
                <div class="grid grid-cols-2 gap-3">
                    <a href="{{ route('auth.facebook') }}" class="flex items-center justify-center px-4 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-sm transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                        Facebook
                    </a>
                    <a href="{{ route('auth.google') }}" class="flex items-center justify-center px-4 py-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-sm transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                            <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                            <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                            <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                        </svg>
                        Google
                    </a>
                </div>
                <div class="text-center mt-4">
                    <span class="text-sm text-gray-500">hoặc đăng nhập bằng</span>
                </div>
            </div>
            
            {{-- Form Action được xử lý an toàn: Nếu route login tồn tại thì dùng, không thì dùng URL tĩnh --}}
            <form action="{{ Route::has('login.store') ? route('login.store') : (Route::has('login') ? route('login') : url('/login')) }}" method="POST" id="auth-form">
                @csrf
                <div class="space-y-6">
                    
                    <div class="register-field hidden" id="name-group">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Họ và Tên</label>
                        <input type="text" name="name" class="w-full bg-gray-50 border border-gray-300 px-4 py-3 text-sm focus:outline-none focus:border-military-red focus:ring-1 focus:ring-military-red transition-all" placeholder="NHẬP HỌ TÊN CỦA BẠN" />
                    </div>
                    
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Địa chỉ Email</label>
                        <input type="email" name="email" required class="w-full bg-gray-50 border border-gray-300 px-4 py-3 text-sm focus:outline-none focus:border-military-red focus:ring-1 focus:ring-military-red transition-all" placeholder="EMAIL QUÂN SỰ / CÁ NHÂN" />
                    </div>

                    <div class="register-field hidden" id="phone-group">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Số Điện Thoại</label>
                        <input type="tel" name="phone" class="w-full bg-gray-50 border border-gray-300 px-4 py-3 text-sm focus:outline-none focus:border-military-red focus:ring-1 focus:ring-military-red transition-all" placeholder="VÍ DỤ: 0901234567" />
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Mật khẩu</label>
                        <input type="password" name="password" required class="w-full bg-gray-50 border border-gray-300 px-4 py-3 text-sm focus:outline-none focus:border-military-red focus:ring-1 focus:ring-military-red transition-all" placeholder="••••••••" />
                    </div>
                    
                    <div class="register-field hidden" id="password-confirm-group">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Xác nhận Mật khẩu</label>
                        <input type="password" name="password_confirmation" class="w-full bg-gray-50 border border-gray-300 px-4 py-3 text-sm focus:outline-none focus:border-military-red focus:ring-1 focus:ring-military-red transition-all" placeholder="••••••••" />
                    </div>
                    
                    <div class="pt-4">
                        <button type="submit" id="auth-submit-button" class="w-full bg-military-red hover:bg-red-900 text-white font-bold uppercase tracking-widest py-4 text-sm transition-all flex justify-center items-center shadow-lg hover:shadow-xl">
                            Đăng Nhập Hệ Thống
                        </button>
                    </div>
                </div>
            </form>

            <div class="mt-6 text-center">
                <p class="text-xs text-gray-400">
                    Bằng việc đăng nhập, bạn đồng ý với <a href="#" class="underline hover:text-military-red">Điều khoản bảo mật</a> của DefenseNews.
                </p>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. Khai báo các phần tử DOM
    const authModal = document.getElementById('auth-modal');
    const loginTab = document.getElementById('login-tab');
    const registerTab = document.getElementById('register-tab');
    const submitButton = document.getElementById('auth-submit-button');
    const authForm = document.getElementById('auth-form');
    
    const nameGroup = document.getElementById('name-group');
    const passwordConfirmGroup = document.getElementById('password-confirm-group');
    const phoneGroup = document.getElementById('phone-group');

    // 2. Định nghĩa URLs từ Laravel
    const loginUrl = "{{ route('login.modal') }}";
    const registerUrl = "{{ route('register.modal') }}";

    if (!authModal || !authForm) return;

    // 3. Hàm xử lý chuyển đổi Đăng nhập / Đăng ký
    window.setAuthMode = function(mode) {
        if (mode === 'LOGIN') {
            loginTab.classList.add('text-military-red', 'border-military-red');
            loginTab.classList.remove('text-gray-400', 'border-transparent');
            registerTab.classList.remove('text-military-red', 'border-military-red');
            registerTab.classList.add('text-gray-400', 'border-transparent');
            
            submitButton.textContent = 'ĐĂNG NHẬP HỆ THỐNG';
            authForm.action = loginUrl;
            
            [nameGroup, passwordConfirmGroup, phoneGroup].forEach(el => el.classList.add('hidden'));
            [nameGroup, passwordConfirmGroup, phoneGroup].forEach(el => el.querySelector('input').removeAttribute('required'));

        } else {
            registerTab.classList.add('text-military-red', 'border-military-red');
            registerTab.classList.remove('text-gray-400', 'border-transparent');
            loginTab.classList.remove('text-military-red', 'border-military-red');
            loginTab.classList.add('text-gray-400', 'border-transparent');
            
            submitButton.textContent = 'ĐĂNG KÝ NGAY';
            authForm.action = registerUrl;

            [nameGroup, passwordConfirmGroup, phoneGroup].forEach(el => el.classList.remove('hidden'));
            [nameGroup, passwordConfirmGroup, phoneGroup].forEach(el => el.querySelector('input').setAttribute('required', 'required'));
        }
    };

    // 4. Các hàm đóng/mở Modal
    window.openAuth = function(mode) {
        authModal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden'); 
        window.setAuthMode(mode);
    };

    window.closeAuth = function() {
        authModal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    };

    // 5. XỬ LÝ GỬI FORM BẰNG AJAX (Quan trọng nhất)
    authForm.addEventListener('submit', function(e) {
        e.preventDefault();

        // Hiệu ứng chờ khi đang xử lý
        const originalText = submitButton.textContent;
        submitButton.textContent = 'ĐANG XỬ LÝ...';
        submitButton.disabled = true;

        const formData = new FormData(this);
        
        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            }
        })
        .then(response => response.json())
       .then(data => {
    if (data.success) {
        window.location.href = data.redirect;
    } else {
        // Kiểm tra nếu có danh sách lỗi chi tiết từ Laravel
        if (data.errors) {
            let errorMessages = Object.values(data.errors).flat().join('\n');
            alert("Lỗi nhập liệu:\n" + errorMessages);
        } else {
            alert(data.message || 'Dữ liệu không hợp lệ.');
        }
        
        // Log ra console để bạn kiểm tra kỹ hơn khi nhấn F12
        console.log('Chi tiết lỗi:', data.errors);
        
        submitButton.textContent = originalText;
        submitButton.disabled = false;
    }
})
    });

    // Đóng modal khi click ra ngoài hoặc phím Esc
    authModal.addEventListener('click', (e) => e.target === authModal && window.closeAuth());
    document.addEventListener('keydown', (e) => e.key === 'Escape' && window.closeAuth());
});
</script>