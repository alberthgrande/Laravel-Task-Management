<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\StatusServiceInterface;
use App\Services\StatusService;

class StatusServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            StatusServiceInterface::class, 
            StatusService::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        logger('✅ PriorityServiceProvider is active!');
    }
}
