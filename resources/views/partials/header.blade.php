<nav class="bg-gray-800 text-white shadow-lg sticky top-0 z-50">
    <div class="container mx-auto px-4 py-3 flex justify-between items-center">
        
        {{-- Logo --}}
       
     <a href="/" class="flex items-center text-3xl font-serif font-black text-military-red tracking-wide">
    <img 
        src="{{ asset('img/logo.png') }}" 
        width="50" 
        height="50" 
        alt="Tiểu đoàn 15"
    />
    {{-- Đặt Text ngay sau thẻ <img> --}}
    <span class="ml-2">Tiểu đoàn 15</span> 
</a>

        {{-- MENU DESKTOP (Ẩn trên màn hình nhỏ) --}}
        {{-- Dùng hidden mặc định, và chỉ hiện thị khi đạt breakpoint md: (768px trở lên) --}}
        <div class="hidden md:flex space-x-4 items-center"> 
            @if(isset($categories))
                @foreach($categories as $category)
                    <a 
                        href="#" 
                        onclick="updateCategory('{{ $category->code }}')"
                        class="text-sm font-bold uppercase tracking-wide px-3 py-2 transition-colors duration-200 hover:text-military-red"
                    >
                        {{ $category->name }} 
                    </a>
                @endforeach
            @endif
        </div>
<div class="flex items-center space-x-3">
    {{-- LOGIC: Nếu người dùng CHƯA đăng nhập (@guest) --}}
    @guest
        {{-- Nút Đăng nhập hiện tại của bạn --}}
        <button onclick="openAuth('LOGIN')" class="bg-white text-military-red px-4 py-1 text-xs font-bold uppercase tracking-widest hover:bg-gray-200 transition">
            Đăng Nhập
        </button>
        {{-- Tùy chọn: Thêm nút Đăng ký nếu nó nằm trong cùng div này --}}
        {{-- <button onclick="openAuth('REGISTER')" class="bg-military-red text-white px-4 py-1 text-xs font-bold uppercase tracking-widest hover:bg-military-red-dark transition">
            Đăng Ký
        </button> --}}
    @endguest

    {{-- LOGIC: Nếu người dùng ĐÃ đăng nhập (@auth) --}}
    @auth
        {{-- 1. Hiển thị Tên người dùng --}}
        <span class="text-white text-sm font-semibold hidden md:block">
            Xin chào, {{ Auth::user()->name }}
        </span>

        {{-- 2. Nút Đăng xuất (Dùng Form POST để đảm bảo bảo mật CSRF) --}}
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="bg-white text-military-red px-4 py-1 text-xs font-bold uppercase tracking-widest hover:bg-gray-200 transition">
                Đăng Xuất
            </button>
        </form>
    @endauth
</div>
<div id="auth-modal" class="fixed inset-0 z-[100] hidden flex items-center justify-center p-4 bg-slate-900/90 backdrop-blur-sm">
    <div class="relative w-full max-w-4xl bg-white shadow-2xl flex overflow-hidden min-h-[600px]">
        
        <button onclick="closeAuth()" class="absolute top-4 right-4 z-10 text-gray-400 hover:text-military-red">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="square" strokeLinejoin="miter" strokeWidth="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>

        <div class="hidden md:block w-1/2 bg-slate-800 relative">
            <img src="https://images.unsplash.com/photo-1542282088-72c9c27ed0cd?q=80&w=1932&auto=format&fit=crop" class="absolute inset-0 w-full h-full object-cover opacity-60 mix-blend-overlay" />
            <div class="absolute inset-0 bg-gradient-to-t from-military-red/80 to-slate-900/60 flex flex-col justify-end p-12 text-white">
                <h2 class="text-4xl font-serif font-black uppercase mb-4 leading-none">Tham Gia<br/>Mạng Lưới</h2>
                <p class="text-sm text-gray-200 font-light opacity-80">
                    Truy cập các bản tin tình báo độc quyền, phân tích chuyên sâu và bình luận từ các chuyên gia hàng đầu.
                </p>
            </div>
        </div>

        <div class="w-full md:w-1/2 p-12 flex flex-col justify-center bg-white relative">
            
            <div class="flex border-b border-gray-200 mb-8">
                <button id="login-tab" onclick="setAuthMode('LOGIN')" class="flex-1 pb-4 text-center text-xs font-bold uppercase tracking-widest transition-colors text-military-red border-b-2 border-military-red">
                    Đăng Nhập
                </button>
                <button id="register-tab" onclick="setAuthMode('REGISTER')" class="flex-1 pb-4 text-center text-xs font-bold uppercase tracking-widest transition-colors text-gray-400 hover:text-gray-600">
                    Đăng Ký
                </button>
            </div>
            
            {{-- THẺ META CSRF ĐÃ ĐƯỢC XÓA KHỎI ĐÂY (NÊN ĐẶT Ở <head> của app.blade.php) --}}
            
            <form onsubmit="handleAuthSubmit(event)">
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
        {{-- NÚT MENU MOBILE (Chỉ hiện thị trên màn hình nhỏ) --}}
        <div class="flex items-center">
            
            {{-- Search Button (Có thể giữ nguyên hoặc ẩn/hiện tùy ý) --}}
            <button class="p-2 hover:text-military-red mr-2"> 
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </button>

            {{-- Nút Burger Menu --}}
            {{-- Dùng md:hidden để ẩn nút này trên desktop --}}
            <button id="mobile-menu-button" class="p-2 md:hidden hover:text-military-red">
                 <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
            </button>
        </div>
    </div>

    {{-- MENU TRÊN MOBILE (Menu ẩn hiện khi bấm nút Burger) --}}
    {{-- Cần thêm CSS/JS để điều khiển trạng thái ẩn/hiện của div này --}}
    <div id="mobile-menu" class="hidden md:hidden bg-gray-700 py-2">
        @if(isset($categories))
            @foreach($categories as $category)
                <a 
                    href="#" 
                    onclick="updateCategory('{{ $category->code }}')"
                    class="block px-4 py-2 text-sm font-bold uppercase tracking-wide transition-colors duration-200 hover:bg-gray-600 hover:text-military-red"
                >
                    {{ $category->name }} 
                </a>
            @endforeach
        @endif
    </div>
    <div class="bg-yellow-500 h-1 w-full shadow-lg"></div>
</nav>



{{-- START: CHỈ MÀU VÀNG PHÂN CÁCH --}}
<div class="bg-yellow-500 h-1 w-full shadow-lg"></div>
{{-- END: CHỈ MÀU VÀNG PHÂN CÁCH --}}
<script>
   document.addEventListener('DOMContentLoaded', function() {
    // 1. KHAI BÁO BIẾN & LẤY ELEMENTS
    
    // Elements của Modal
    const authModal = document.getElementById('auth-modal');
    const loginTab = document.getElementById('login-tab');
    const registerTab = document.getElementById('register-tab');
    const submitButton = document.getElementById('auth-submit-button');
    
    // Các trường Đăng ký
    const nameGroup = document.getElementById('name-group');
    const passwordConfirmGroup = document.getElementById('password-confirm-group');
    const phoneGroup = document.getElementById('phone-group'); // <<< KHAI BÁO MỚI CHO PHONE

    // Kiểm tra các phần tử thiết yếu có tồn tại không
    // Cập nhật kiểm tra để bao gồm phoneGroup
    if (!authModal || !loginTab || !registerTab || !submitButton || !nameGroup || !passwordConfirmGroup || !phoneGroup) { 
        console.error("Auth Modal or its core elements not found in the DOM. Check your HTML structure for required IDs (name-group, password-confirm-group, phone-group).");
        return; 
    }

    // 2. KHAI BÁO CÁC HÀM TOÀN CỤC (Gán vào window)

    /**
     * Mở Modal và thiết lập chế độ
     */
    window.openAuth = function(mode) {
        authModal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden'); 
        window.setAuthMode(mode);
    }

    /**
     * Đóng Modal
     */
    window.closeAuth = function() {
        authModal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    /**
     * Thay đổi giữa giao diện Đăng nhập và Đăng ký (Tab switch)
     */
    window.setAuthMode = function(mode) {
        if (mode === 'LOGIN') {
            // Cập nhật UI Tabs
            loginTab.classList.add('text-military-red', 'border-military-red');
            loginTab.classList.remove('text-gray-400', 'border-transparent');
            registerTab.classList.remove('text-military-red', 'border-military-red');
            registerTab.classList.add('text-gray-400', 'border-transparent');
            submitButton.textContent = 'ĐĂNG NHẬP HỆ THỐNG';

            // Ẩn các trường Đăng ký và loại bỏ required
            nameGroup.classList.add('hidden');
            passwordConfirmGroup.classList.add('hidden');
            phoneGroup.classList.add('hidden'); // <<< ẨN PHONE
            
            nameGroup.querySelector('input').removeAttribute('required');
            passwordConfirmGroup.querySelector('input').removeAttribute('required');
            phoneGroup.querySelector('input').removeAttribute('required'); // <<< LOẠI BỎ REQUIRED PHONE

        } else if (mode === 'REGISTER') {
            // Cập nhật UI Tabs
            registerTab.classList.add('text-military-red', 'border-military-red');
            registerTab.classList.remove('text-gray-400', 'border-transparent');
            loginTab.classList.remove('text-military-red', 'border-military-red');
            loginTab.classList.add('text-gray-400', 'border-transparent');
            submitButton.textContent = 'ĐĂNG KÝ NGAY';

            // Hiển thị các trường Đăng ký và thêm required
            nameGroup.classList.remove('hidden');
            passwordConfirmGroup.classList.remove('hidden');
            phoneGroup.classList.remove('hidden'); // <<< HIỂN THỊ PHONE

            nameGroup.querySelector('input').setAttribute('required', 'required');
            passwordConfirmGroup.querySelector('input').setAttribute('required', 'required');
            phoneGroup.querySelector('input').setAttribute('required', 'required'); // <<< THÊM REQUIRED PHONE
        }
    }

 