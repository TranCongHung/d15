<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource for the admin panel.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Article::with(['author', 'category'])->latest()->paginate(15);
        return view('admin.articles.index', compact('articles'));
    }


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