<?php

namespace App\Models;

// Các lớp cần thiết (Imports)
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     * CÁC TRƯỜNG ĐƯỢC PHÉP DÙNG KHI SỬ DỤNG User::create()
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        
        // >> CẬP NHẬT: Thêm các cột tùy chỉnh (role và phone) vào fillable
        'role',
        'phone', 
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed', // <-- Đảm bảo dòng này tồn tại (Đây là lý do mật khẩu được băm tự động)
    ];
    
    // Tùy chọn: Thêm hàm helper để kiểm tra vai trò dễ dàng hơn
    public function isAdmin()
    {
        return $this->role !== 'user';
    }
}