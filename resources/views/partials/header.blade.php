<header class="bg-white font-sans shadow-sm relative z-50">
    {{-- 1. TOP BAR --}}
    <div class="bg-slate-900 text-slate-300 text-xs py-2">
        <div class="container mx-auto px-4 flex justify-between items-center">
            <div class="hidden md:flex items-center gap-4">
                <span>{{ now()->locale('vi')->translatedFormat('l, d/m/Y') }}</span>
                <span class="w-px h-3 bg-slate-700"></span>
                <span>Nghệ An, Việt Nam</span>
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
<nav class="bg-[#880000] sticky top-0 z-40 shadow-md">
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