<?php

namespace Database\Factories; // <-- Cú pháp đúng

use App\Models\User;
use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str; // <-- Thêm import Str
use Faker\Factory as Faker;

class ArticleFactory extends Factory
{
    protected $model = Article::class;

    public function definition(): array
    {
        // 1. Tạo title ngẫu nhiên với timestamp để đảm bảo unique
        $topics = [
            'Nâng cao chất lượng huấn luyện',
            'Đảm bảo kỹ thuật tăng thiết giáp',
            'Công tác Đảng trong lực lượng vũ trang',
            'Chiến lược phòng thủ biển đảo',
            'Đào tạo cán bộ quân sự hiện đại',
            'Bảo vệ biên giới quốc gia',
            'Hợp tác quốc tế quân sự',
            'Công nghệ quân sự tiên tiến',
            'Đào tạo binh chủng đặc biệt',
            'Chiến tranh mạng và an ninh thông tin'
        ];

        $years = ['2024', '2025', '2026'];
        $title = $topics[array_rand($topics)] . ' năm ' . $years[array_rand($years)] . ' - ' . uniqid();

        return [
            'title' => $title,

            // 2. THÊM SLUG DỰA TRÊN TITLE VỪA TẠO
            'slug' => Str::slug($title),

            'excerpt' => 'Tóm tắt bài viết về chủ đề quan trọng trong quân đội và quốc phòng.',
            'body' => 'Nội dung chi tiết của bài viết về các vấn đề quân sự quan trọng, chiến lược quốc phòng và nhiệm vụ bảo vệ tổ quốc...',
            'category_id' => \App\Models\Category::inRandomOrder()->first()->id,
            'published_at' => now()->subDays(rand(1, 30)),
            'author_id' => \App\Models\User::inRandomOrder()->first()->id,
        ];
    }
}