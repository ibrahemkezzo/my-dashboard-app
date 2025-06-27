<?php

namespace App\Providers;

use App\Contracts\AnalyticsInterface;
use App\Factories\StorageStrategyFactory;
use App\Repositories\DatabaseSettingsRepository;
use App\Repositories\VisitRepository;
use App\Services\MediaService;
use App\Services\SettingsService;
use App\Services\VisitAnalyticsService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(StorageStrategyFactory::class, function ($app) {
            return new StorageStrategyFactory();
        });

        $this->app->bind(MediaService::class, function ($app) {
            return new MediaService($app->make(StorageStrategyFactory::class));
        });

        $this->app->bind(SettingsService::class, function ($app) {
            return new SettingsService(new DatabaseSettingsRepository());
        });

        $this->app->singleton(VisitRepository::class, function () {
            return new VisitRepository();
        });

        $this->app->bind(AnalyticsInterface::class, VisitAnalyticsService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
