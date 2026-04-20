<?php

namespace App\Providers;

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
        if (!function_exists('t_label')) {
            function t_label(string $key): string {
                return \App\Helpers\TenantHelper::getLabel($key);
            }
        }
    }
}
