<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Article;
use App\Models\User;
use App\Models\Category;
use App\Models\Comment;

class AdminController extends Controller
{

public function index()
{
    // Lấy dữ liệu thực từ MySQL
    $articles = Article::with('author')->latest()->get();
    $users = User::all();
    $categories = Category::withCount('articles')->get();
    $comments = Comment::latest()->limit(10)->get();

    // Thống kê
    $articleCount = Article::count();
    $userCount = User::count();
    $commentCount = Comment::count();
    $failedCount = 0;

    // Logs hệ thống
    $logs = [
        ['time' => now()->subHours(1)->format('H:i:s'), 'type' => 'success', 'message' => 'Cập nhật bài viết thành công'],
        ['time' => now()->subHours(2)->format('H:i:s'), 'type' => 'info', 'message' => 'Người dùng mới đăng ký'],
        ['time' => now()->subHours(3)->format('H:i:s'), 'type' => 'warning', 'message' => 'Dung lượng storage sắp đầy'],
    ];

    return view('admin.index', compact(
        'articles', 'users', 'categories', 'comments',
        'articleCount', 'userCount', 'commentCount', 'failedCount',
        'logs'
    ));
}
}