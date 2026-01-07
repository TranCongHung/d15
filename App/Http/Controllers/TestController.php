<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->get('q');

        if (empty($query)) {
            return redirect()->route('home');
        }

        $articles = Article::where('title', 'LIKE', "%{$query}%")
            ->whereNotNull('published_at')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('search', compact('articles', 'query'));
    }
}