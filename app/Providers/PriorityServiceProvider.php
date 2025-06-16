<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\PriorityServiceInterface;
use App\Services\PriorityService;

class PriorityServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        
        $this->app->bind(
            PriorityServiceInterface::class, 
            PriorityService::class
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
