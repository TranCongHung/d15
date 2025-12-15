<?php

namespace Database\Factories; // <-- Cú pháp đúng

use App\Models\User;
use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str; // <-- Thêm import Str

class ArticleFactory extends Factory
{
    protected $model = Article::class;

    public function definition(): array
    {
        // 1. Tạo title trước
        $title = $this->faker->sentence();
        
        return [
            'title' => $title,
            
            // 2. THÊM SLUG DỰA TRÊN TITLE VỪA TẠO
            'slug' => Str::slug($title), 
            
            'excerpt' => $this->faker->paragraph(2), 
            'body' => $this->faker->paragraphs(3, true),
            'category_id' => \App\Models\Category::inRandomOrder()->first()->id, 
            'published_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'author_id' => \App\Models\User::inRandomOrder()->first()->id, 
        ];
    }
}