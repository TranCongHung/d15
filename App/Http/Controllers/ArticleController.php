<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Hiển thị một bài viết cụ thể dựa trên slug.
     * Sử dụng Implicit Route Model Binding để tìm Article.
     */
   
    
public function show($slug)
{
    // Lệnh này tìm bài viết VÀ TĂNG view_count
    $article = Article::with(['category', 'author'])
        ->where('slug', $slug)
        ->firstOrFail();

    $article->increment('view_count'); // Đảm bảo đã load xong mới tăng view count

    // Lấy tin phổ biến cho Sidebar
    $popularArticles = Article::orderBy('view_count', 'desc')->take(5)->get();

    return view('articles.show', compact('article', 'popularArticles'));
}

}