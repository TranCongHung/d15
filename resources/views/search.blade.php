@extends('layouts.app')

@section('title', 'Kết quả tìm kiếm: ' . $query)

@section('content')
<main class="container mx-auto px-4 py-12">
    <div class="flex flex-col lg:flex-row gap-12">
        <!-- Main Content -->
        <div class="lg:w-2/3">
            <!-- Search Results Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-serif font-bold text-gray-900 mb-2">Kết quả tìm kiếm</h1>
                <p class="text-gray-600">
                    Tìm thấy <span class="font-semibold text-military-red">{{ $latestArticles->total() }}</span> kết quả cho từ khóa:
                    <span class="font-semibold">"{{ $query }}"</span>
                </p>
            </div>

            @if($latestArticles->count() > 0)
                <div class="space-y-8">
                    @foreach($latestArticles as $article)
                        <!-- Article Card -->
                        <article class="bg-white border border-gray-200 shadow-sm hover:shadow-md transition-shadow duration-300">
                            <!-- Article Image -->
                            @if($article->image_url)
                                <div class="aspect-video overflow-hidden">
                                    <img
                                        src="{{ $article->image_url }}"
                                        alt="{{ $article->title }}"
                                        class="w-full h-full object-cover hover:scale-105 transition-transform duration-300"
                                    />
                                </div>
                            @endif

                            <!-- Article Content -->
                            <div class="p-6">
                                <!-- Category Badge -->
                                <div class="mb-3">
                                    <span class="inline-block bg-military-red text-white text-xs font-bold uppercase px-3 py-1 rounded-sm">
                                        {{ $article->category->name }}
                                    </span>
                                </div>

                                <!-- Article Title -->
                                <h2 class="text-xl font-bold text-gray-900 mb-3 line-clamp-2">
                                    <a href="{{ route('articles.show', $article->slug) }}" class="hover:text-military-red transition-colors">
                                        {{ $article->title }}
                                    </a>
                                </h2>

                                <!-- Article Excerpt -->
                                <p class="text-gray-600 mb-4 line-clamp-3">
                                    {{ $article->excerpt }}
                                </p>

                                <!-- Article Meta -->
                                <div class="flex items-center justify-between text-sm text-gray-500">
                                    <div class="flex items-center space-x-4">
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                            {{ $article->author->name ?? 'Không xác định' }}
                                        </span>
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            {{ $article->created_at->diffForHumans() }}
                                        </span>
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            {{ $article->view_count }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-12">
                    {{ $latestArticles->appends(['q' => $query])->links() }}
                </div>
            @else
                <!-- No Results -->
                <div class="text-center py-16">
                    <div class="mb-6">
                        <svg class="w-24 h-24 text-gray-300 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Không tìm thấy kết quả</h3>
                    <p class="text-gray-600 mb-6">Không có bài viết nào phù hợp với từ khóa "{{ $query }}".</p>
                    <a href="{{ route('home') }}" class="inline-flex items-center px-4 py-2 bg-military-red text-white font-semibold rounded-sm hover:bg-red-700 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Về trang chủ
                    </a>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="lg:w-1/3">
            @include('partials.sidebar')
        </div>
    </div>
</main>
@endsection
