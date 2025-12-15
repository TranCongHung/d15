@extends('layouts.app')

@section('content')
<div class="bg-gray-50 pb-12 font-sans text-slate-800">
  
  <div class="bg-white border-b border-gray-200">
     <div class="container mx-auto px-4 py-3 text-xs font-bold uppercase tracking-wider text-gray-500">
        <a href="{{ route('home') }}" class="cursor-pointer hover:text-military-red">Trang Chủ</a> 
        <span class="mx-2">/</span> 
        <span class="cursor-pointer hover:text-military-red">{{ $article->category?->name ?? 'Tin tức' }}</span>
        <span class="mx-2">/</span>
        <span class="text-military-red">Chi Tiết</span>
     </div>
  </div>

  <div class="w-full h-[400px] md:h-[500px] relative">
     <img src="{{ $article->image_url ?? 'https://picsum.photos/1200/800?grayscale' }}" class="w-full h-full object-cover" alt="{{ $article->title }}" />
     <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent"></div>
     
     <div class="absolute bottom-0 left-0 w-full container mx-auto px-4 pb-8 md:pb-12 text-white">
        <span class="bg-military-red px-3 py-1 text-xs font-bold uppercase tracking-widest mb-4 inline-block shadow-lg">
            {{ $article->category?->name ?? 'Quân sự' }}
        </span>
        <h1 class="text-3xl md:text-5xl font-serif font-bold leading-tight drop-shadow-lg max-w-4xl">
            {{ $article->title }}
        </h1>
     </div>
  </div>

  <div class="container mx-auto px-4 py-8 -mt-20 relative z-10">
     <div class="flex flex-col lg:flex-row gap-12">
        
        <div class="lg:w-2/3">
           <div class="bg-white p-8 md:p-12 shadow-sm border border-gray-100">
              
              <div class="flex items-center justify-between border-b border-gray-100 pb-6 mb-8">
                 <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gray-200 rounded-full overflow-hidden">
                      <img src="https://ui-avatars.com/api/?name={{ urlencode($article->author?->name ?? 'Admin') }}&background=8B0000&color=fff" alt="Avatar" />
                    </div>
                    <div>
                       <div class="text-xs font-bold uppercase text-gray-900">{{ $article->author?->name ?? 'Người dùng không tồn tại' }}</div>
                       <div class="text-xs text-gray-500">Phóng viên quốc phòng</div>
                    </div>
                 </div>
                 <div class="text-right">
                    <div class="text-xs font-bold text-gray-400 uppercase tracking-wide">
                        {{ $article->created_at?->diffForHumans() ?? 'Không rõ thời gian' }}
                    </div>
                 </div>
              </div>

              <article class="prose prose-slate prose-lg max-w-none font-serif text-gray-800 leading-8">
                 {{-- Đoạn văn đầu tiên với chữ cái lớn (Drop cap) --}}
                 <div class="first-letter:text-5xl first-letter:font-black first-letter:text-military-red first-letter:float-left first-letter:mr-3 first-letter:leading-none">
                    {!! nl2br(e($article->excerpt)) !!}
                 </div>
                 
                 <div class="mt-6">
                    {!! $article->body !!} {{-- Dùng {!! !!} nếu body chứa HTML từ editor, nếu text thuần thì dùng {{ nl2br(e($article->body)) }} --}}
                 </div>
              </article>
              
              {{-- Hiển thị Gallery nếu có dữ liệu (Ví dụ giả định) --}}
              @if(isset($article->gallery) && count($article->gallery) > 0)
              <div class="mt-12 mb-8">
                   <h4 class="text-lg font-bold text-military-red uppercase tracking-widest mb-6 border-l-4 border-military-red pl-4 flex items-center justify-between">
                      Thư Viện Ảnh Tác Chiến
                   </h4>
                   <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                       @foreach($article->gallery as $image)
                       <div class="group relative aspect-video overflow-hidden bg-gray-100 cursor-pointer shadow-sm border border-gray-200">
                           <img src="{{ $image }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105 filter grayscale group-hover:grayscale-0" />
                       </div>
                       @endforeach
                   </div>
               </div>
               @endif

              <div class="mt-8 pt-8 border-t border-gray-200 flex justify-between items-center">
                
                 <div class="flex gap-2">
                    <span class="text-xs font-bold text-gray-400 uppercase self-center mr-2">Thẻ:</span>
                    <span class="bg-gray-100 text-gray-600 text-xs px-2 py-1 uppercase font-bold">Quân Sự</span>
                    <span class="bg-gray-100 text-gray-600 text-xs px-2 py-1 uppercase font-bold">{{ $article->category?->name }}</span>
                 </div>
              </div>
           </div>

           @include('articles.comments', ['article' => $article, 'comments' => $article->comments])

        </div>

        <div class="lg:w-1/3">
            {{-- Đảm bảo bạn truyền biến $popularArticles từ ArticleController@show --}}
            @include('partials.sidebar', ['mostRead' => $popularArticles])
        </div>

     </div>
  </div>
</div>
@endsection