<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    public function create()
    {
        return view('admin.articles_create', [
            'categories' => Category::all()
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'excerpt'     => 'nullable|string',
            'body'        => 'required|string',
            'category_id' => 'nullable|exists:categories,id',
            'thumbnail'   => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('thumbnail')) {
            $data['image_url'] = $request->file('thumbnail')
                ->store('articles', 'public');
        }

        $data['author_id'] = Auth::id();
        $data['view_count'] = 0;
        $data['published_at'] = now();

        Article::create($data);

        return redirect()
            ->route('admin.articles.create')
            ->with('success', 'Đăng bài thành công');
    }
}
