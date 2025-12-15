<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash; 
use Illuminate\Support\Carbon; // <--- KHUYẾN NGHỊ THÊM DÒNG NÀY (hoặc Carbon\Carbon)

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin_seed_new@example.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'), 
                'email_verified_at' => now(),
                
                // <<< CUNG CẤP GIÁ TRỊ CHO CÁC CỘT MỚI >>>
                'phone' => '0901234567',
                'role' => 'admin', // Gán vai trò là 'admin' cho tài khoản này
                // <<< KẾT THÚC CUNG CẤP GIÁ TRỊ >>>
            ] 
        );
    }
}