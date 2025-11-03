<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind('App\Models\Document', function ($app) {
            // If Document doesn't exist, use File
            if (!class_exists('App\Models\Document')) {
                return $app->make('App\Models\File');
            }
            return new \App\Models\Document;
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
    }
}