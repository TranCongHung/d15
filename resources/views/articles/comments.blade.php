@php
    // SỬA ĐỔI 1: LẤY BÌNH LUẬN THỰC TẾ từ mối quan hệ
    // Giả định bạn đã Eager Load 'comments.user' trong ArticleController
    $comments = $article->comments ?? collect(); // Sử dụng collect() để đảm bảo là một Collection rỗng
    $commentCount = $comments->count(); 
@endphp

<div class="mt-8 bg-white p-8 md:p-12 shadow-sm border border-gray-100">
    <h3 class="text-lg font-bold uppercase tracking-wide text-slate-900 mb-6 flex items-center">
        Bình Luận ({{ $commentCount }})
        <span class="ml-2 w-16 h-0.5 bg-military-red block"></span>
    </h3>

    {{-- PHẦN 1: KHU VỰC GỬI BÌNH LUẬN --}}
    
    <div class="flex gap-4 mb-10">
        {{-- Ảnh đại diện (Avatar) --}}
        <div class="w-10 h-10 bg-slate-200 flex-shrink-0 flex items-center justify-center font-bold text-gray-400">
            @auth
                {{ Auth::user()->name[0] }}
            @else
                ?
            @endauth
        </div>
        
        <div class="flex-grow">
            {{-- Form Bình luận (Chỉ hiển thị khi đã đăng nhập) --}}
            @auth
                {{-- SỬA ĐỔI 2: Đảm bảo route nhận slug hoặc ID article --}}
                <form method="POST" action="{{ route('comments.store', $article->slug) }}">
                    @csrf
                    <textarea 
                        name="content" 
                        class="w-full bg-gray-50 border border-gray-200 p-3 text-sm focus:outline-none focus:border-military-red transition-colors" 
                        rows="3" 
                        placeholder="Chia sẻ ý kiến của bạn..."
                        required
                    >{{ old('content') }}</textarea>
                    
                    @error('content')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror

                    <button type="submit" class="mt-2 bg-slate-900 text-white px-6 py-2 text-xs font-bold uppercase tracking-widest hover:bg-military-red transition">
                        Gửi Bình Luận
                    </button>
                </form>
            @else
                {{-- Thông báo yêu cầu đăng nhập để bình luận
                <div class="bg-gray-100 border border-military-red p-4 text-sm text-gray-700">
                    Bạn cần <a href="{{ route('login') }}" class="text-military-red font-bold underline hover:text-red-800">Đăng nhập</a> để bình luận về bài viết này.
                </div>
                 --}}
            @endauth
        </div>
    </div>

    {{-- PHẦN 2: DANH SÁCH BÌNH LUẬN --}}
    
    <div class="space-y-8">
        @forelse ($comments as $comment)
            @php
                // SỬA ĐỔI 3: Áp dụng Nullsafe Operator cho user
                $user = $comment->user;
                // Giả sử $user?->role được sử dụng, nếu không có cột role, cần xóa dòng này.
                // Nếu User Model có role, thì đây là cách kiểm tra an toàn:
                $isExpert = $user?->role === 'Chuyên gia'; 
            @endphp
            <div class="flex gap-4 border-b border-gray-100 pb-8">
                {{-- Avatar --}}
                <div class="w-10 h-10 bg-slate-100 flex items-center justify-center font-bold text-gray-400 flex-shrink-0">
                    {{ $user?->name[0] ?? '?' }} {{-- BẢO VỆ NULL --}}
                </div>
                <div>
                    <div class="flex items-center gap-2 mb-1">
                        <span class="text-sm font-bold text-slate-900 uppercase">{{ $user?->name ?? 'Người dùng đã xóa' }}</span> {{-- BẢO VỆ NULL --}}
                        
                        @if ($isExpert)
                            <span class="bg-yellow-100 text-yellow-700 text-[10px] px-1 font-bold uppercase border border-yellow-200">Chuyên gia</span>
                        @endif
                        
                        <span class="text-xs text-gray-400">
                            • {{ $comment->created_at->diffForHumans() }}
                        </span>
                    </div>
                    <p class="text-sm text-gray-700 leading-relaxed">{{ $comment->content }}</p>
                    
                    {{-- Nút Tương tác --}}
                    <div class="flex gap-4 mt-2">
                        <button class="text-xs font-bold text-gray-400 hover:text-military-red uppercase">Trả lời</button>
                        <button class="text-xs font-bold text-gray-400 hover:text-military-red uppercase">Thích</button>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-10 text-gray-500">
                Chưa có bình luận nào. Hãy là người đầu tiên bình luận!
            </div>
        @endforelse
    </div>
</div>