<?php

namespace App\Providers;

use App\Services\MediaService;
use App\Services\Storage\MorphMediaStorage;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(MediaService::class, function ($app) {
            return new MediaService(new MorphMediaStorage());
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
