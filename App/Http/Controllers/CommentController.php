<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Article $article)
    {
        // 1. Validation
        $request->validate([
            'content' => 'required|string|min:5|max:1000',
        ]);

        // 2. Tạo Comment mới
        $comment = new Comment();
        $comment->user_id = auth()->id(); // Lấy ID của người dùng đang đăng nhập
        $comment->article_id = $article->id; // Gán ID bài viết
        $comment->content = $request->input('content');
        $comment->save();
        
        // 3. Chuyển hướng trở lại trang bài viết
        return redirect()
            ->route('articles.show', $article->slug)
            ->with('success', 'Bình luận của bạn đã được gửi thành công!');
    }
}