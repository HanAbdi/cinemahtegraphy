<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

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
            if (\Illuminate\Support\Facades\Schema::hasTable('company_settings')) {
                $view->with('companySettings', \App\Models\CompanySetting::getSettings());
            }
        });
    }
}
