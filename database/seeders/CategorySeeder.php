<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Lục Quân', 'code' => 'LUC_QUAN'],
            ['name' => 'Hải Quân', 'code' => 'HAI_QUAN'],
            ['name' => 'Không Quân', 'code' => 'KHONG_QUAN'],
            ['name' => 'Thông tin', 'code' => 'THONG_TIN'],
        ];

        foreach ($categories as $category) {
            // Thay vì tạo trực tiếp, sử dụng firstOrCreate để tránh lỗi trùng lặp
            Category::firstOrCreate(
                ['name' => $category['name']], // Điều kiện tìm kiếm
                ['code' => $category['code']]  // Dữ liệu để tạo nếu không tìm thấy
            );
        }
    }
}