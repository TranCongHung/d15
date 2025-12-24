<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str; // <-- Cần thiết cho việc tạo slug tự động
use App\Models\Comment;
class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'author_id',
        'category_id',
        'title',
        'slug', // <-- THÊM 'slug' VÀO fillable
        'excerpt',
        'image_url',
        'view_count',
        'body', // Thêm body nếu bạn có trong migration
    ];
    
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($article) {
            if (empty($article->slug)) {
                $article->slug = Str::slug($article->title);
            }
        });
    }

    // =========================================================
    // TẠO SLUG TỰ ĐỘNG (Mutator/Accessor)
    // =========================================================
    
    // Đảm bảo slug luôn được tạo từ title khi lưu vào database
    public function setSlugAttribute(?string $value): void
    {
        // Nếu giá trị slug không được cung cấp, tự tạo từ title
        if (empty($value) && isset($this->attributes['title'])) {
            $this->attributes['slug'] = Str::slug($this->attributes['title']);
        } else {
            // Nếu có giá trị slug được truyền, vẫn đảm bảo nó được làm sạch (slugify)
            $this->attributes['slug'] = Str::slug($value);
        }
    }


    // =========================================================
    // ĐỊNH NGHĨA MỐI QUAN HỆ (RELATIONSHIP)
    // =========================================================

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function category(): BelongsTo // <-- Đã sửa: Giữ lại 1 định nghĩa
    {
        // Không cần tham số thứ hai nếu tên khóa ngoại là 'category_id' (tên mặc định)
        return $this->belongsTo(Category::class);
    }
  public function comments(): \Illuminate\Database\Eloquent\Relations\HasMany
{
    return $this->hasMany(Comment::class);
}
}