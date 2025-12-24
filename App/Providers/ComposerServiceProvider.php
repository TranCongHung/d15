<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View; // Import Facade View
use App\Models\Category; // Import Model Category

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // View Composer sẽ gắn biến $categories vào partials/header.blade.php
        View::composer('partials.header', function ($view) {
            // Lấy tất cả danh mục từ database
            $categories = Category::all();
            
            // Thêm mục "Trang Chủ" thủ công vào đầu Collection
            $homeCategory = new Category(['code' => 'ALL', 'name' => 'Trang Chủ']);
            
            // Thêm mục Trang Chủ vào đầu danh sách Categories
            $categories = collect([$homeCategory])->merge($categories);

            // Gắn biến $categories vào view
            $view->with('categories', $categories);
        });
    }
}