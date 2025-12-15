<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
{
    Schema::create('articles', function (Blueprint $table) {
        $table->id();
        
        // Khóa ngoại
        $table->foreignId('author_id')->constrained('users')->onDelete('cascade');
        $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
        
        // Các cột dữ liệu
        $table->string('title', 255);
        $table->string('slug')->unique(); // <-- Đảm bảo dòng này đúng cú pháp
        $table->text('excerpt');
        $table->longText('body'); // Đảm bảo body có, nếu không sẽ lỗi Seeder sau đó
        $table->string('image_url')->nullable();
        $table->unsignedInteger('view_count')->default(0);
        $table->timestamp('published_at')->nullable(); // Thêm nếu bạn có cột này
        
        $table->timestamps();
    });
}
  public function down(): void
{
    Schema::dropIfExists('articles'); // <-- Đã sửa thành 'articles'
}
};