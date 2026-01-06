<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Category;

class HomeController extends Controller
{
    /**
     * Trang chủ / danh sách bài viết
     */
    public function index()
    {
        $latestArticles = Article::with(['author', 'category'])
            ->whereNotNull('published_at')
            ->latest()
            ->paginate(8);

        $popularArticles = Article::with(['author', 'category'])
            ->whereNotNull('published_at')
            ->orderByDesc('view_count')
            ->limit(4)
            ->get();

        return view('home', compact(
            'latestArticles',
            'popularArticles'
        ));
    }

    /**
     * Trang chi tiết bài viết
     */
    public function show(string $slug)
    {
        $article = Article::with(['author', 'category', 'comments.user'])
            ->where('slug', $slug)
            ->whereNotNull('published_at')
            ->firstOrFail();

        // Tăng lượt xem
        $article->increment('view_count');

        return view('articles.show', compact('article'));
    }
}
