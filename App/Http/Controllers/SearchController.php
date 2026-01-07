<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Category;

class SearchController extends Controller
{
    /**
     * Tìm kiếm bài viết theo tên
     */
    public function search(Request $request)
    {
        $query = $request->get('q');

        if (!$query) {
            return redirect()->route('home');
        }

        $latestArticles = Article::with(['author', 'category'])
            ->whereNotNull('published_at')
            ->where('title', 'LIKE', "%{$query}%")
            ->latest()
            ->paginate(12);

        $mostRead = Article::with(['author', 'category'])
            ->whereNotNull('published_at')
            ->orderByDesc('view_count')
            ->limit(4)
            ->get();

        return view('search', compact('latestArticles', 'mostRead', 'query'));
    }
}
