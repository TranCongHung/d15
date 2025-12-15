<aside class="space-y-8">
    
    {{-- 1. ĐỌC NHIỀU NHẤT (MOST READ) --}}
    <div class="bg-white border border-gray-200 shadow-sm">
        {{-- Tiêu đề Widget --}}
        <div class="bg-slate-800 text-white px-4 py-3 border-l-4 border-military-red">
            <h3 class="font-bold uppercase tracking-wider text-sm">Đọc Nhiều Nhất</h3>
        </div>

        @if($mostRead->isNotEmpty())
            <ul class="divide-y divide-gray-100 p-4">
                @foreach($mostRead as $article)
                    {{-- Thêm liên kết xung quanh toàn bộ mục danh sách --}}
                    <li class="py-4 first:pt-0 last:pb-0">
                        <a href="{{ route('articles.show', $article->slug) }}" class="flex gap-4 items-start group">
                            
                            {{-- Hình ảnh thu nhỏ --}}
                            <div class="w-24 h-16 flex-shrink-0 overflow-hidden bg-gray-200">
                                <img 
                                    src="{{ $article->image_url }}" 
                                    alt="{{ $article->title }}" 
                                    class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105" 
                                />
                            </div>
                            
                            <div class="flex-grow">
                                <p class="text-xs font-bold uppercase text-military-red mb-1">{{ $article->category->name }}</p>
                                <h4 class="text-sm font-bold text-gray-800 line-clamp-2 group-hover:text-military-red transition-colors">
                                    {{ $article->title }}
                                </h4>
                                <span class="text-xs text-gray-500 mt-1 block">{{ $article->created_at->diffForHumans() }}</span>
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-sm text-gray-500 p-4">Chưa có bài viết phổ biến.</p>
        @endif
    </div>

    {{-- 2. HỘP TIN ĐĂNG KÝ (NEWSLETTER) --}}
    {{-- Thay đổi màu nền để khớp với thiết kế frontend ban đầu: bg-military-red --}}
    <div class="p-6 bg-military-red text-white shadow-lg">
        <h3 class="text-xl font-serif font-bold mb-2">Bản Tin Quân Sự</h3>
        <p class="text-sm text-red-100 mb-4 font-light">Nhận phân tích chiến lược hàng tuần vào email của bạn.</p>
        <form action="#" method="POST" class="space-y-3">
            <input type="email" placeholder="Email của bạn" required class="w-full p-3 text-slate-900 text-sm focus:outline-none focus:ring-1 focus:ring-yellow-400 transition">
            {{-- Nút có màu tương phản --}}
            <button type="submit" class="w-full bg-slate-900 hover:bg-black text-white py-2 text-xs font-bold uppercase tracking-widest transition">
                Đăng Ký Ngay
            </button>
        </form>
    </div>
    
    {{-- 3. ẢNH/TWEET (GALLERY) --}}
    <div class="p-4 bg-white border border-gray-200 shadow-sm">
        <h3 class="text-xl font-serif font-bold text-gray-900 mb-4 uppercase border-b border-gray-200 pb-2">Góc ảnh</h3>
        <div class="grid grid-cols-3 gap-1">
            {{-- Đây là một ví dụ về bố cục Gallery, tôi chia nhỏ các ảnh thành 3 cột --}}
            <a href="#" class="block overflow-hidden aspect-square hover:opacity-80 transition"><img src="https://picsum.photos/300/300?grayscale&random=11" alt="Ảnh 1" class="w-full h-full object-cover"></a>
            <a href="#" class="block overflow-hidden aspect-square hover:opacity-80 transition"><img src="https://picsum.photos/300/300?grayscale&random=12" alt="Ảnh 2" class="w-full h-full object-cover"></a>
            <a href="#" class="block overflow-hidden aspect-square hover:opacity-80 transition"><img src="https://picsum.photos/300/300?grayscale&random=13" alt="Ảnh 3" class="w-full h-full object-cover"></a>
            <a href="#" class="block overflow-hidden aspect-square hover:opacity-80 transition"><img src="https://picsum.photos/300/300?grayscale&random=14" alt="Ảnh 4" class="w-full h-full object-cover"></a>
            <a href="#" class="block overflow-hidden aspect-square hover:opacity-80 transition"><img src="https://picsum.photos/300/300?grayscale&random=15" alt="Ảnh 5" class="w-full h-full object-cover"></a>
            <a href="#" class="block overflow-hidden aspect-square hover:opacity-80 transition"><img src="https://picsum.photos/300/300?grayscale&random=16" alt="Ảnh 6" class="w-full h-full object-cover"></a>
        </div>
    </div>
    
</aside>