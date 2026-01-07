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

    {{-- 2. TÌM KIẾM BÀI VIẾT --}}
    <div class="p-6 bg-military-red text-white shadow-lg">
        <h3 class="text-xl font-serif font-bold mb-2">Tìm Kiếm</h3>
        <p class="text-sm text-red-100 mb-4 font-light">Tìm kiếm bài viết theo từ khóa trong tiêu đề.</p>
        <form action="{{ route('search') }}" method="GET" class="space-y-3">
            <input type="text" name="q" placeholder="Nhập từ khóa..." required class="w-full p-3 text-slate-900 text-sm focus:outline-none focus:ring-1 focus:ring-yellow-400 transition" value="{{ request('q') }}">
            {{-- Nút có màu tương phản --}}
            <button type="submit" class="w-full bg-slate-900 hover:bg-black text-white py-2 text-xs font-bold uppercase tracking-widest transition flex items-center justify-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                Tìm Kiếm
            </button>
        </form>
    </div>
    
    {{-- 3. VIDEO ĐƠN VỊ --}}
    <div class="p-4 bg-white border border-gray-200 shadow-sm">
        <h3 class="text-xl font-serif font-bold text-gray-900 mb-4 uppercase border-b border-gray-200 pb-2">Video đơn vị</h3>
        <div class="aspect-video">
            <iframe
                width="100%"
                height="100%"
                src="https://www.youtube.com/embed/nJwm7z7a6Ik"
                title="YouTube video player"
                frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                referrerpolicy="strict-origin-when-cross-origin"
                allowfullscreen>
            </iframe>
        </div>
    </div>
    
</aside>