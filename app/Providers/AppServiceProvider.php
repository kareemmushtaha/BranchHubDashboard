<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
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
        // تخصيص pagination views لاستخدام Bootstrap 5
        Paginator::defaultView('custom.pagination.bootstrap-5');
        Paginator::defaultSimpleView('custom.pagination.simple-bootstrap-5');
    }
}
