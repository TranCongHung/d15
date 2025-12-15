<?php

use Illuminate\Support\ServiceProvider; // DÒNG NÀY PHẢI CÓ Ở ĐẦU FILE

return [

    /*
    |--------------------------------------------------------------------------
    | Application Service Providers
    |--------------------------------------------------------------------------
    |
    | The service providers listed here will be automatically loaded on the
    | request to your application. Feel free to add your own services to
    | this array to grant expanded functionality to your applications.
    |
    */

    'providers' => ServiceProvider::defaultProviders()->merge([
        /*
         * Application Service Providers...
         */
        \App\Providers\AppServiceProvider::class,
        \App\Providers\AuthServiceProvider::class,
        \App\Providers\BroadcastServiceProvider::class,
        \App\Providers\EventServiceProvider::class,
        \App\Providers\RouteServiceProvider::class,
        
        // CUSTOM PROVIDER CỦA CHÚNG TA:
        \App\Providers\ComposerServiceProvider::class, 

    ])->toArray(),

    // ... (Các cấu hình khác như 'name', 'env', 'debug', v.v. ở dưới)
];