@extends('layouts.app')

@section('content')
    {{-- Start: Hero Banner Section (Đoạn 1) --}}
<section class="bg-black text-white">
    
    {{-- Top Red Strip --}}
    <div class="bg-military-red h-3"></div>

    {{-- Content Container --}}
    <div class="container mx-auto px-4 py-16 lg:py-24">
        
        {{-- Metadata/Category Tag --}}
        <div class="inline-block px-3 py-1 mb-6 bg-military-red text-white text-xs font-bold uppercase tracking-widest rounded-sm">
            HẢI QUÂN
        </div>

        {{-- Main Title --}}
        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold leading-tight mb-6 max-w-4xl font-serif">
            Việt Nam Tăng Cường Năng Lực Phòng Thủ Bờ Biển Với Hệ Thống Radar Mới
        </h1>

        {{-- Excerpt/Summary --}}
        <p class="text-lg text-gray-300 mb-10 max-w-3xl">
            Hệ thống radar cảnh báo sớm thế hệ mới đã chính thức được triển khai tại các điểm trọng yếu, nâng cao đáng kể khả năng giám sát vùng biển.
        </p>

        {{-- Action Buttons --}}
        <div class="flex space-x-4 items-center">
            
            {{-- Primary Button: ĐỌC CHI TIẾT --}}
            <a href="#" class="flex items-center justify-center px-6 py-3 bg-military-red text-black font-bold uppercase tracking-wider text-sm transition-colors duration-200 hover:bg-red-700 hover:text-white rounded-sm">
                ĐỌC CHI TIẾT
                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M9 5l7 7-7 7"></path></svg>
            </a>        
        </div>
        
    </div>
</section>
    <div class="container mx-auto px-4 py-12">
        
        {{-- BỐ CỤC 2/3 (Nội dung chính) - 1/3 (Sidebar) --}}
        <div class="flex flex-col lg:flex-row gap-12">
            
            {{-- Vùng Nội dung Chính (2/3) --}}
            <div class="lg:w-2/3">
                <h2 class="text-2xl font-serif font-bold text-gray-900 mb-6 border-b-2 border-military-red pb-2 uppercase tracking-wide">
                    Tin nóng 24h
                </h2>
                
                @if($latestArticles->isNotEmpty())
                    {{-- Đặt tất cả bài viết vào Grid 2 cột --}}
                    <div class="grid md:grid-cols-2 gap-8">
                        @foreach($latestArticles as $article)
                            {{-- Card Bài viết --}}
                            <a href="{{ route('articles.show', $article->slug) }}" class="block group">
                                <div class="bg-white shadow-sm hover:shadow-xl transition-shadow duration-300 border border-gray-100 flex flex-col h-full">
                                    
                                    {{-- Hình ảnh --}}
                                    <div class="relative overflow-hidden h-48 bg-gray-200">
                                        {{-- Giả định $article->image_url chứa URL ảnh chính --}}
                                        <img 
                                            src="{{ $article->image_url }}" 
                                            alt="{{ $article->title }}" 
                                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" 
                                        />
                                        {{-- Bạn có thể thêm tag 'Nóng' nếu cần --}}
                                        @if($article->is_breaking)
                                            <div class="absolute top-0 right-0 bg-red-600 text-white text-xs font-bold px-2 py-1 uppercase animate-pulse">Nóng</div>
                                        @endif
                                    </div>
                                    
                                    <div class="p-5 flex flex-col flex-grow">
                                        <div class="flex items-center justify-between mb-2">
                                            {{-- Giả định $article->category là mối quan hệ đã tải --}}
                                            <span class="text-xs font-bold text-military-red uppercase tracking-wider">{{ $article->category->name }}</span>
                                            <span class="text-xs text-gray-400">{{ $article->created_at->diffForHumans() }}</span>
                                        </div>
                                        
                                        {{-- Tiêu đề --}}
                                        <h3 class="font-serif font-bold text-xl text-gray-900 mb-3 leading-tight group-hover:text-military-red transition-colors">
                                            {{ $article->title }}
                                        </h3>
                                        
                                        {{-- Tóm tắt --}}
                                        <p class="text-gray-600 text-sm line-clamp-3 mb-4 flex-grow font-light">
                                            {{ $article->excerpt }}
                                        </p>
                                        
                                        {{-- Tác giả và Chi tiết --}}
                                        <span class="text-xs font-bold uppercase tracking-widest text-slate-800 group-hover:text-military-red transition flex items-center mt-auto">
                                            Xem thêm <span class="ml-1">→</span>
                                        </span>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-10 border border-dashed border-gray-300">Không tìm thấy bài viết nào.</p>
                @endif
                
                {{-- Khu vực Phân trang (Pagination) --}}
                @if($latestArticles->hasPages())
                    <div class="mt-8">
                        {{ $latestArticles->links() }}
                    </div>
                @endif
            </div>

            {{-- Vùng Sidebar (1/3) --}}
            <div class="lg:w-1/3">
                {{-- Truyền biến $popularArticles (Đọc nhiều nhất) vào partial sidebar --}}
                {{-- Đảm bảo partials/sidebar.blade.php có logic renderCard(compact) --}}
                @include('partials.sidebar', ['mostRead' => $popularArticles])
            </div>
            
        </div>
    </div>
@endsection

@section('scripts')
    <script type="module">
        // Logic JS đơn giản hóa để chuyển danh mục (được gọi từ partials/header.blade.php)
        window.updateCategory = function(categoryCode) {
            // Thay thế logic này bằng route Laravel thực tế nếu bạn muốn lọc theo category code
            window.location.href = categoryCode === 'ALL' ? '{{ route('home') }}' : `{{ url('/') }}/${categoryCode.toLowerCase()}`;
        }
        
        // Cần đảm bảo modal được định nghĩa trong layouts.app hoặc một partial khác.
        window.openModal = function() {
            const modal = document.getElementById('ai-modal');
            if(modal) modal.classList.remove('hidden');
        }
        window.closeModal = function() {
            const modal = document.getElementById('ai-modal');
            if(modal) modal.classList.add('hidden');
        }
        
        // Để sử dụng trong phần Đăng nhập/Đăng ký của header
        window.openAuth = function(mode) {
             // Logic mở Auth Modal
             // Thay thế bằng mã JS thực tế để mở modal và chuyển chế độ
             console.log(`Mở modal xác thực ở chế độ: ${mode}`);
             // Ví dụ: document.getElementById('auth-modal').classList.remove('hidden');
        }
    </script>
@endsection