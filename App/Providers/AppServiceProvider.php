<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        // Ép buộc HTTPS khi dùng Ngrok hoặc LocalTunnel để tránh lỗi giao diện/form
        if (str_contains(request()->getHost(), 'ngrok') || str_contains(request()->getHost(), 'loca.lt')) {
            URL::forceScheme('https');
        }
    }
}
