<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

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
     *
     * WHY Paginator::useBootstrap()?
     * By default, Laravel renders Tailwind CSS pagination links.
     * This project uses Bootstrap (from the Soft UI Dashboard theme),
     * so we switch the paginator to use Bootstrap-compatible HTML.
     * This makes $products->links() in Blade render <ul class="pagination">.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();
    }
}

