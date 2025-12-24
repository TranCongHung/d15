<header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-8 z-10">
    <div class="flex items-center">
        <button class="text-gray-500 hover:text-military-red lg:hidden mr-4">
            <i data-lucide="menu" class="w-6 h-6"></i>
        </button>
        <h2 class="text-lg font-medium text-gray-700" id="page-title">
            @yield('page_title', 'Bảng điều khiển')
        </h2>
    </div>

    <div class="flex items-center space-x-4">
        {{-- Tìm kiếm --}}
        <div class="relative hidden md:block">
            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                <i data-lucide="search" class="w-4 h-4"></i>
            </span>
            <input type="text" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md bg-gray-50 focus:outline-none focus:ring-1 focus:ring-military-red sm:text-sm" placeholder="Tìm kiếm...">
        </div>

        {{-- Thông tin User & Dropdown --}}
        <div class="relative ml-4 border-l pl-4" x-data="{ open: false }">
            <button @click="open = !open" class="flex items-center focus:outline-none hover:opacity-80 transition">
                <div class="text-right mr-3 hidden sm:block">
                    @auth
                        <p class="text-sm font-bold text-gray-700 leading-none">{{ Auth::user()->name }}</p>
                        <p class="text-[10px] text-military-red mt-1 uppercase font-semibold">{{ Auth::user()->role }}</p>
                    @endauth
                </div>
                
                <div class="w-10 h-10 rounded-full bg-military-red flex items-center justify-center text-white font-bold shadow-sm border border-gray-200">
                    @auth
                        {{ mb_strtoupper(mb_substr(Auth::user()->name, 0, 1)) }}
                    @else
                        <i data-lucide="user" class="w-5 h-5"></i>
                    @endauth
                </div>
            </button>

            {{-- Dropdown Menu (Yêu cầu Alpine.js hoặc bạn dùng JS thường) --}}
            <div x-show="open" @click.away="open = false" 
                 class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-md shadow-lg py-1 z-50">
                <div class="px-4 py-2 border-b border-gray-100 sm:hidden">
                    <p class="text-sm font-bold">{{ Auth::user()->name ?? '' }}</p>
                </div>
                <a href="/" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                    <i data-lucide="home" class="w-4 h-4 mr-2"></i> Xem trang chủ
                </a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 flex items-center">
                        <i data-lucide="log-out" class="w-4 h-4 mr-2"></i> Đăng xuất
                    </button>
                </form>
            </div>
        </div>