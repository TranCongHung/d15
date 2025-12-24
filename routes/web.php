<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| 1. ROUTES ƯU TIÊN CAO (Đường dẫn cố định)
|--------------------------------------------------------------------------
*/

// Trang chủ
Route::get('/', [HomeController::class, 'index'])->name('home');

// Trang Dashboard Admin (Phải để trên các route động để không bị hiểu lầm là category)
Route::get('/dashboard', [AdminController::class, 'index'])
    ->name('dashboard')
    ->middleware('auth');

/*
|--------------------------------------------------------------------------
| 2. ROUTES AUTH & HÀNH ĐỘNG (POST)
|--------------------------------------------------------------------------
*/


Route::post('/register-modal', [RegisterController::class, 'registerModal'])->name('register.modal');
Route::post('/login-modal', [RegisterController::class, 'loginModal'])->name('login.modal');

// Routes for standard form submission
Route::get('/login', fn() => redirect()->route('home'))->name('login.form');
Route::post('/login', [RegisterController::class, 'login'])->name('login');
Route::get('/register', fn() => redirect()->route('home'))->name('register.form');
Route::post('/register', [RegisterController::class, 'register'])->name('register');

Route::post('/logout', function (Illuminate\Http\Request $request) { 
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/'); 
})->name('logout');


/*
|--------------------------------------------------------------------------
| 4. ADMIN ARTICLE MANAGEMENT ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
    Route::get('/articles/create', [ArticleController::class, 'create'])->name('articles.create');
    Route::post('/articles', [ArticleController::class, 'store'])->name('articles.store');
});


/*
|--------------------------------------------------------------------------
| 3. ROUTES DỮ LIỆU ĐỘNG (Phải để dưới cùng)
|--------------------------------------------------------------------------
*/

// Route bài viết chi tiết (Có tiền tố /articles/ nên an toàn)
Route::get('/articles/{slug}', [ArticleController::class, 'show'])->name('articles.show');

// Route Danh mục (Cực kỳ nguy hiểm - PHẢI ĐỂ CUỐI CÙNG)
// Vì nó chấp nhận mọi chuỗi ký tự sau dấu "/", nếu để lên đầu nó sẽ tranh chấp với /dashboard
Route::get('/{category}', [HomeController::class, 'index'])->name('category');