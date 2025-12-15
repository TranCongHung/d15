<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,      // Cần thiết để tạo Tác giả
            CategorySeeder::class,  // Cần thiết để tạo Danh mục
            ArticleSeeder::class,   // CẦN PHẢI CÓ DÒNG NÀY!
            // ... có thể có các Seeder khác
        ]);
    }
}