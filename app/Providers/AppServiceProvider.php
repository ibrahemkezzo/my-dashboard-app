<?php

namespace App\Providers;

use App\Contracts\AnalyticsInterface;
use App\Factories\StorageStrategyFactory;
use App\Repositories\DatabaseSettingsRepository;
use App\Repositories\UserRepository;
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

        // Bind VisitRepository interface
        $this->app->bind(\App\Contracts\VisitRepositoryInterface::class, VisitRepository::class);

        $this->app->bind(AnalyticsInterface::class, VisitAnalyticsService::class);

        // Register UserActivityService
        $this->app->bind(\App\Contracts\UserActivityInterface::class, \App\Services\UserActivityService::class);
        $this->app->bind(\App\Services\UserActivityService::class, function ($app) {
            return new \App\Services\UserActivityService(
                $app->make(\App\Contracts\VisitRepositoryInterface::class),
                $app->make(UserRepository::class)
            );
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
