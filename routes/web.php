<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AdminController; // Import Controller cho Dashboard

// ===============================================
// 1. CÁC ROUTES CHUNG
// ===============================================

// Route cho trang chủ (ALL category)
Route::get('/', [HomeController::class, 'index'])->name('home');

// Route cho danh mục cụ thể (Ví dụ: /luc_quan, /hai_quan)
Route::get('/{category}', [HomeController::class, 'index'])->name('category');

// Route hiển thị bài viết chi tiết
Route::get('/articles/{slug}', [ArticleController::class, 'show'])->name('articles.show');


// ===============================================
// 2. ROUTES XỬ LÝ AUTH (AJAX)
// ===============================================

// Route POST cho đăng ký (Sử dụng RegisterController)
Route::post('/register-modal', [RegisterController::class, 'registerModal'])->name('register.modal');

// Route POST cho đăng nhập (Sử dụng RegisterController đã được chỉnh sửa logic role)
Route::post('/login-modal', [RegisterController::class, 'loginModal'])->name('login.modal');


// ===============================================
// 3. LOGIC CHUYỂN HƯỚNG THEO ROLE
// ===============================================

/**
 * Route Dashboard / Trang quản trị
 * Đây là route được trả về cho người dùng KHÔNG phải 'user' (admin, editor).
 * * Lưu ý: Bạn cần tạo AdminController (hoặc tên tương đương)
 */
// Tạm thời thay thế AdminController để đảm bảo route hoạt động
Route::get('/dashboard', function () {
    return "Chào mừng Admin! Route Dashboard hoạt động.";
})->name('dashboard')->middleware('auth');

// ===============================================
// 4. ROUTE ĐĂNG XUẤT
// ===============================================

// ROUTE ĐĂNG XUẤT
Route::post('/logout', function (Illuminate\Http\Request $request) { 
    Auth::logout(); // Đăng xuất người dùng

    $request->session()->invalidate(); // Hủy bỏ session hiện tại
    $request->session()->regenerateToken(); // Tạo lại token CSRF mới

    // Chuyển hướng người dùng về trang chủ
    return redirect('/'); 
})->name('logout');