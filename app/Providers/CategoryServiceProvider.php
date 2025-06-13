<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\CategoryServiceInterface;
use App\Services\CategoryService;

class CategoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            CategoryServiceInterface::class, 
            CategoryService::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        logger('✅ CategoryServiceProvider is active!');
    }
}
