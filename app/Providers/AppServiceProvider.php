<?php

namespace App\Providers;
use Illuminate\Support\Facades\View;
use App\Models\SystemInfo;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $system = SystemInfo::first();
            $view->with('system', $system);
        });
    }
}
