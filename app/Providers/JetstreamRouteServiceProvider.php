<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class JetstreamRouteServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Route::middleware(['web', 'auth', 'track.visit']) // ← أضف الميدل وير هنا
        ->group(base_path('vendor/laravel/jetstream/routes/livewire.php'));
    }
}
