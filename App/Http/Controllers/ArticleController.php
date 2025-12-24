<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource for the admin panel.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Article::with(['author', 'category'])->latest()->get();
        return view('admin.articles.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.articles.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'category_id' => 'required|exists:categories,id',
        ]);

        // Generate a unique slug.
        $slug = Str::slug($validatedData['title']);
        $uniqueSlug = $slug;
        $counter = 1;
        while (Article::where('slug', $uniqueSlug)->exists()) {
            $uniqueSlug = $slug . '-' . $counter;
            $counter++;
        }

        $article = Article::create([
            'title' => $validatedData['title'],
            'body' => $validatedData['body'],
            'category_id' => $validatedData['category_id'],
            'author_id' => Auth::id(),
            'slug' => $uniqueSlug,
        ]);

        // Load relationships for the JSON response
        $article->load('author', 'category');

        if ($request->wantsJson()) {
            return response()->json(['article' => $article, 'message' => 'Bài viết đã được tạo thành công.'], 201);
        }

        return redirect()->route('admin.articles.index')->with('success', 'Bài viết đã được tạo thành công.');
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