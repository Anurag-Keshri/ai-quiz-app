<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
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
        Route::pattern('quiz', '[0-9]+');
		Route::pattern('question', '[0-9]+');
		Route::pattern('attempt', '[0-9]+');
    }
}
