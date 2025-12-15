<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany; // Import cần thiết

class Category extends Model
{
    use HasFactory;

    /**
     * Tên bảng trong cơ sở dữ liệu.
     * Mặc định là 'categories'
     */
    // protected $table = 'categories'; 

    /**
     * Các thuộc tính có thể gán hàng loạt (mass assignable).
     */
    protected $fillable = [
        'name',
        'code', // Mã danh mục (ví dụ: LUC_QUAN)
    ];

    // =========================================================
    // ĐỊNH NGHĨA MỐI QUAN HỆ (RELATIONSHIP)
    // =========================================================

    /**
     * Lấy tất cả bài viết thuộc về danh mục này.
     * (Mối quan hệ One-to-Many: Một Category có nhiều Articles)
     */
    public function articles(): HasMany
    {
        // Liên kết bằng khóa ngoại 'category_id' trong bảng 'articles'
        return $this->hasMany(Article::class, 'category_id');
    }
}