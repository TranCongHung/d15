<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article; // Phải có để dùng Article::factory()
use App\Models\Category; // Nếu bạn cần liên kết Category

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 1. Kiểm tra xem có Category nào không (vì Article cần category_id)
        if (Category::count() === 0) {
            // Nếu CategorySeeder không chạy, bạn nên chạy CategorySeeder trước.
            // Hoặc tạo một Category mặc định tạm thời:
            // $category = Category::create(['name' => 'Default']);
        }
        
        // 2. Chạy Factory để tạo dữ liệu bài viết
        Article::factory()
            ->count(50) // Tạo 50 bài viết
            ->create();
    }
}// KHÔNG CÓ BẤT KỲ ĐỊNH NGHĨA CLASS NÀO KHÁC BÊN DƯỚI NÀY!

