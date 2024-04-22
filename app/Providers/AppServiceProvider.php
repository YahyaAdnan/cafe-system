<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\PrintingService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(PrintingService::class,function ($app)
             {
            return new PrintingService();
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
