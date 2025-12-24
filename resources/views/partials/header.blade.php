<header class="bg-white font-sans shadow-sm relative z-50">
    {{-- 1. TOP BAR --}}
    <div class="bg-slate-900 text-slate-300 text-xs py-2">
        <div class="container mx-auto px-4 flex justify-between items-center">
            <div class="hidden md:flex items-center gap-4">
                <span>{{ now()->locale('vi')->translatedFormat('l, d/m/Y') }}</span>
                <span class="w-px h-3 bg-slate-700"></span>
                <span>Hotline: 0987.654.321</span>
            </div>
            
            <div class="flex items-center gap-4 ml-auto md:ml-0">
                @guest
                    {{-- Sử dụng onclick để mở Modal thay vì gọi route('login') gây lỗi --}}
                    <button onclick="openAuth('LOGIN')" class="hover:text-white transition-colors uppercase font-bold cursor-pointer">Đăng nhập</button>
                    <span class="w-px h-3 bg-slate-700"></span>
                    <button onclick="openAuth('REGISTER')" class="hover:text-white transition-colors uppercase font-bold cursor-pointer">Đăng ký</button>
                @else
                    <div class="flex items-center gap-2">
                        <span class="text-white font-bold">Hi, {{ Auth::user()->name }}</span>
                        @if(Auth::user()->role === 'admin')
                            <a href="{{ route('dashboard') }}" class="text-yellow-500 hover:text-yellow-400 text-[10px] uppercase border border-yellow-600 px-1 rounded">Admin</a>
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
                <div class="w-12 h-12 bg-red-800 text-white flex items-center justify-center font-black text-xl rounded shadow-sm group-hover:bg-slate-900 transition-colors duration-300">
                    D15
                </div>
                <div class="flex flex-col">
                    <span class="text-2xl font-black uppercase tracking-widest text-slate-900 leading-none group-hover:text-red-800 transition-colors duration-300">
                        QĐNDVN
                    </span>
                    <span class="text-xs text-slate-500 font-bold tracking-wider uppercase mt-1">
                        Tin tức Quân sự - Quốc phòng
                    </span>
                </div>
            </a>

            <div class="hidden md:block w-1/3">
                <div class="relative">
                    <input type="text" placeholder="Tìm kiếm tin tức..." class="w-full pl-4 pr-10 py-2 bg-gray-50 border border-gray-200 rounded text-sm focus:outline-none focus:border-red-800 focus:ring-1 focus:ring-red-800 transition-all">
                    <button class="absolute right-0 top-0 h-full px-3 text-gray-400 hover:text-red-800">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- 3. NAVIGATION MENU --}}
    <nav class="bg-slate-800 text-white sticky top-0 z-40 shadow-lg border-t-4 border-red-800">
        <div class="container mx-auto px-4">
            <div class="md:hidden flex justify-between items-center py-3">
                <span class="font-bold uppercase">Danh mục</span>
                <button onclick="document.getElementById('mobile-menu').classList.toggle('hidden')" class="text-white focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>

            <ul class="hidden md:flex flex-wrap items-center gap-1">
                @foreach($categories as $category)
                    <li>
                        <a href="{{ $category->code === 'ALL' ? route('home') : '#' }}" 
                           class="block px-5 py-4 text-sm font-bold uppercase tracking-wider hover:bg-red-800 hover:text-white transition-all duration-200 {{ (request()->routeIs('home') && $category->code === 'ALL') ? 'bg-red-800' : 'text-gray-300' }}">
                            {{ $category->name }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
        
        <div id="mobile-menu" class="hidden md:hidden bg-slate-900 border-t border-slate-700">
            <ul class="flex flex-col">
                @foreach($categories as $category)
                    <li>
                        <a href="{{ $category->code === 'ALL' ? route('home') : '#' }}" 
                           class="block px-4 py-3 text-sm font-bold uppercase border-b border-slate-800 hover:bg-red-800 hover:text-white transition-colors">
                            {{ $category->name }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </nav>
</header>

{{-- AUTH MODAL --}}
<div id="auth-modal" class="fixed inset-0 z-[100] hidden flex items-center justify-center p-4 bg-slate-900/90 backdrop-blur-sm">
    <div class="relative w-full max-w-4xl bg-white shadow-2xl flex overflow-hidden min-h-[600px] rounded-sm">
        
        <button onclick="closeAuth()" class="absolute top-4 right-4 z-10 text-gray-400 hover:text-military-red">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="square" strokeLinejoin="miter" strokeWidth="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>

        {{-- Left Side: Image --}}
        <div class="hidden md:block w-1/2 bg-slate-800 relative">
            <img src="https://images.unsplash.com/photo-1542282088-72c9c27ed0cd?q=80&w=1932&auto=format&fit=crop" class="absolute inset-0 w-full h-full object-cover opacity-60 mix-blend-overlay" />
            <div class="absolute inset-0 bg-gradient-to-t from-military-red/80 to-slate-900/60 flex flex-col justify-end p-12 text-white">
                <h2 class="text-4xl font-serif font-black uppercase mb-4 leading-none">Tham Gia<br/>Mạng Lưới</h2>
                <p class="text-sm text-gray-200 font-light opacity-80">
                    Truy cập các bản tin tình báo độc quyền, phân tích chuyên sâu và bình luận từ các chuyên gia hàng đầu.
                </p>
            </div>
        </div>

        {{-- Right Side: Form --}}
        <div class="w-full md:w-1/2 p-12 flex flex-col justify-center bg-white relative">
            
            <div class="flex border-b border-gray-200 mb-8">
                <button id="login-tab" onclick="setAuthMode('LOGIN')" class="flex-1 pb-4 text-center text-xs font-bold uppercase tracking-widest transition-colors text-military-red border-b-2 border-military-red">
                    Đăng Nhập
                </button>
                <button id="register-tab" onclick="setAuthMode('REGISTER')" class="flex-1 pb-4 text-center text-xs font-bold uppercase tracking-widest transition-colors text-gray-400 hover:text-gray-600">
                    Đăng Ký
                </button>
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
    const authModal = document.getElementById('auth-modal');
    const loginTab = document.getElementById('login-tab');
    const registerTab = document.getElementById('register-tab');
    const submitButton = document.getElementById('auth-submit-button');
    const authForm = document.getElementById('auth-form');
    
    const nameGroup = document.getElementById('name-group');
    const passwordConfirmGroup = document.getElementById('password-confirm-group');
    const phoneGroup = document.getElementById('phone-group');

    // URL an toàn được render từ server
    const loginUrl = "{{ Route::has('login.store') ? route('login.store') : (Route::has('login') ? route('login') : url('/login')) }}";
    const registerUrl = "{{ Route::has('register.store') ? route('register.store') : (Route::has('register') ? route('register') : url('/register')) }}";

    if (!authModal || !loginTab || !registerTab || !submitButton) return;

    window.openAuth = function(mode) {
        authModal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden'); 
        window.setAuthMode(mode);
    }

    window.closeAuth = function() {
        authModal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    window.setAuthMode = function(mode) {
        if (mode === 'LOGIN') {
            loginTab.classList.add('text-military-red', 'border-military-red');
            loginTab.classList.remove('text-gray-400', 'border-transparent');
            registerTab.classList.remove('text-military-red', 'border-military-red');
            registerTab.classList.add('text-gray-400', 'border-transparent');
            submitButton.textContent = 'ĐĂNG NHẬP HỆ THỐNG';
            
            // Cập nhật action của form
            if(authForm) authForm.action = loginUrl;
            
            nameGroup.classList.add('hidden');
            passwordConfirmGroup.classList.add('hidden');
            phoneGroup.classList.add('hidden');
            
            nameGroup.querySelector('input').removeAttribute('required');
            passwordConfirmGroup.querySelector('input').removeAttribute('required');
            phoneGroup.querySelector('input').removeAttribute('required');

        } else if (mode === 'REGISTER') {
            registerTab.classList.add('text-military-red', 'border-military-red');
            registerTab.classList.remove('text-gray-400', 'border-transparent');
            loginTab.classList.remove('text-military-red', 'border-military-red');
            loginTab.classList.add('text-gray-400', 'border-transparent');
            submitButton.textContent = 'ĐĂNG KÝ NGAY';

            // Cập nhật action của form
            if(authForm) authForm.action = registerUrl;

            nameGroup.classList.remove('hidden');
            passwordConfirmGroup.classList.remove('hidden');
            phoneGroup.classList.remove('hidden');

            nameGroup.querySelector('input').setAttribute('required', 'required');
            passwordConfirmGroup.querySelector('input').setAttribute('required', 'required');
            phoneGroup.querySelector('input').setAttribute('required', 'required');
        }
    }

    // Close modal when clicking outside
    authModal.addEventListener('click', function(e) {
        if (e.target === authModal) {
            window.closeAuth();
        }
    });

    // Close modal on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !authModal.classList.contains('hidden')) {
            window.closeAuth();
        }
    });
   });
</script>