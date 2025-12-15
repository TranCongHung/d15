<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        // 1. Lấy bài viết mới nhất cho khu vực chính (Sử dụng ->paginate() để kích hoạt phân trang)
        // Lưu ý: Dùng ->latest() gọn hơn ->orderBy('created_at', 'desc')
        $latestArticles = Article::with(['author', 'category'])
            ->latest() // Sắp xếp theo created_at DESC
            ->paginate(8); // Lấy 8 bài viết/trang và tạo đối tượng Paginator
            
        // 2. Lấy bài viết phổ biến nhất cho Sidebar (Sử dụng ->get() vì không cần phân trang)
        $popularArticles = Article::with(['author', 'category'])
            ->orderBy('view_count', 'desc')
            ->limit(4) // Giới hạn 4 bài
            ->get(); // Lấy Collection

        // Trả về view với các biến đã được load đúng cách
        return view('home', compact(
            'latestArticles', 
            'popularArticles'
        ));
    }
}