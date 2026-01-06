<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\AdminController;
use App\Models\Article;
use App\Http\Controllers\ArticleController;

/*
|--------------------------------------------------------------------------
| 1. ROUTES ƯU TIÊN CAO (Đường dẫn cố định)
|--------------------------------------------------------------------------
*/

// Trang chủ
Route::get('/', [HomeController::class, 'index'])->name('home');

// Tìm kiếm
Route::get('/search', [HomeController::class, 'search'])->name('search');


// Comments routes
Route::post('/articles/{article:slug}/comments', [CommentController::class, 'store'])->name('comments.store');

// Trang Dashboard Admin (Phải để trên các route động để không bị hiểu lầm là category)
Route::get('/dashboard', [AdminController::class, 'index'])
    ->name('dashboard')
    ->middleware('auth');

/*
|--------------------------------------------------------------------------
| 2. ROUTES AUTH & HÀNH ĐỘNG (POST)
|--------------------------------------------------------------------------
*/


Route::post('/register-modal', [RegisterController::class, 'registerModal'])->name('register.modal')->withoutMiddleware(['csrf']);
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
// Route admin thật với auth đã được thay thế bằng route test ở trên
// Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
//     Route::get('/', [AdminController::class, 'index'])->name('dashboard'); // Admin dashboard
// });

/*
|--------------------------------------------------------------------------
| ADMIN ROUTE - No Auth For Testing
|--------------------------------------------------------------------------
*/
// Admin routes without auth for testing
Route::prefix('admin')->name('admin.')->withoutMiddleware(['web'])->group(function () {
    Route::get('/', function () {
        // Lấy dữ liệu thực từ database
        $articles = \App\Models\Article::latest()->get()->map(function ($article) {
            return (object)[
                'id' => $article->id,
                'title' => $article->title,
                'cat' => 'Chưa phân loại', // Temporary
                'user' => 'Không xác định', // Temporary
                'status' => $article->published_at ? 'published' : 'draft',
                'views' => $article->view_count,
                'content' => $article->body ?? $article->excerpt,
                'created_at' => $article->created_at,
                'updated_at' => $article->updated_at,
            ];
        });

        $users = \App\Models\User::all()->map(function ($user) {
            return (object)[
                'id' => $user->id,
                'name' => $user->name,
                'rank' => $user->rank ?? 'Không xác định',
                'role' => $user->role ?? 'Người dùng',
                'email' => $user->email,
                'joined' => $user->created_at->format('d/m/Y'),
            ];
        });

        $categories = [];
        $comments = [];
        $logs = [];

        $articleCount = $articles->count();
        $userCount = $users->count();
        $commentCount = $comments ? count($comments) : 0;
        $failedCount = 0;

        return view('admin.index', compact('articles', 'users', 'categories', 'comments', 'logs', 'articleCount', 'userCount', 'commentCount', 'failedCount'));
    })->name('dashboard');

    // API routes for CRUD operations
    Route::post('/articles', function (Illuminate\Http\Request $request) {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|integer|min:1|max:4', // Allow category IDs 1-4 for now
            'body' => 'required|string',
            'excerpt' => 'nullable|string|max:500', // Excerpt tối đa 500 ký tự
            'image_url' => 'nullable|string',
            'status' => 'nullable|string|in:published,draft',
        ]);

        // Tạo excerpt nếu không được cung cấp
        $excerpt = $validated['excerpt'];
        if (empty($excerpt)) {
            // Lấy 150 ký tự đầu từ body, loại bỏ HTML tags và khoảng trắng thừa
            $cleanBody = strip_tags($validated['body']);
            $excerpt = Str::limit($cleanBody, 150, '...');
        }

        $article = Article::create([
            'author_id' => 1, // Default author, you can change this
            'category_id' => $validated['category_id'],
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']),
            'body' => $validated['body'],
            'excerpt' => $excerpt,
            'image_url' => $validated['image_url'] ?? null,
            'view_count' => 0,
            'published_at' => $request->status === 'published' ? now() : null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Bài viết đã được tạo thành công!',
            'article' => [
                'id' => $article->id,
                'title' => $article->title,
                'cat' => $article->category->name ?? 'Chưa phân loại',
                'user' => $article->author->name ?? 'Không xác định',
                'status' => $article->published_at ? 'published' : 'draft',
                'views' => $article->view_count,
                'content' => $article->body,
                'created_at' => $article->created_at,
                'updated_at' => $article->updated_at,
            ]
        ]);
    })->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);

    Route::put('/articles/{article}', function (Illuminate\Http\Request $request, \App\Models\Article $article) {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'body' => 'required|string',
            'excerpt' => 'nullable|string|max:500', // Excerpt tối đa 500 ký tự
            'image_url' => 'nullable|url',
            'published_at' => 'nullable|date',
        ]);

        // Tạo excerpt nếu không được cung cấp
        $excerpt = $validated['excerpt'];
        if (empty($excerpt)) {
            // Lấy 150 ký tự đầu từ body, loại bỏ HTML tags và khoảng trắng thừa
            $cleanBody = strip_tags($validated['body']);
            $excerpt = Str::limit($cleanBody, 150, '...');
        }

        $article->update([
            'category_id' => $validated['category_id'],
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']),
            'body' => $validated['body'],
            'excerpt' => $excerpt,
            'image_url' => $validated['image_url'] ?? null,
            'published_at' => $validated['published_at'] ?? ($request->status === 'published' ? now() : null),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Bài viết đã được cập nhật thành công!',
            'article' => [
                'id' => $article->id,
                'title' => $article->title,
                'cat' => $article->category->name ?? 'Chưa phân loại',
                'user' => $article->author->name ?? 'Không xác định',
                'status' => $article->published_at ? 'published' : 'draft',
                'views' => $article->view_count,
                'content' => $article->body,
                'created_at' => $article->created_at,
                'updated_at' => $article->updated_at,
            ]
        ]);
    });

    Route::delete('/articles/{article}', function (\App\Models\Article $article) {
        $article->delete();

        return response()->json([
            'success' => true,
            'message' => 'Bài viết đã được xóa thành công!'
        ]);
    });
});

/*
|--------------------------------------------------------------------------
| TEST ROUTE - No Auth Required
|--------------------------------------------------------------------------
*/
Route::get('/test-form', function () {
    return view('test-form');
})->name('test.form');

Route::get('/test-db', function () {
    return response()->json([
        'articles' => \App\Models\Article::count(),
        'users' => \App\Models\User::count(),
        'status' => 'OK'
    ]);
});

Route::get('/sach-su', function () {
    // Đảm bảo tên trong view('...') phải khớp với tên file .blade.php bạn đã tạo
    return view('historical'); 
})->name('sach-su');
Route::get('/lich-su', function () {
    // Đảm bảo tên trong view('...') phải khớp với tên file .blade.php bạn đã tạo
    return view('DevelopmentHistory'); 
})->name('lich-su');
Route::get('/thi', function () {
    // Đảm bảo tên trong view('...') phải khớp với tên file .blade.php bạn đã tạo
    return view('Awareness'); 
})->name('thi');
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

