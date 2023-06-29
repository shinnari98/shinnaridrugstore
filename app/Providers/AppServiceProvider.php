<?php

namespace App\Providers;

use App\Models\Categories;
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
        Paginator::useBootstrap();

        view()->composer('drugstore.header.header', function ($view) {
            $categories = Categories::all(); 
            $view->with('categories', $categories);
        });

        view()->composer('drugstore.header.userHeader', function ($view) {
            $categories = Categories::all(); 
            $view->with('categories', $categories);
        });

        view()->composer('drugstore.header.adminHeader', function ($view) {
            $categories = Categories::all(); 
            $view->with('categories', $categories);
        });

        view()->composer('drugstore.header.producerHeader', function ($view) {
            $categories = Categories::all(); 
            $view->with('categories', $categories);
        });
    }
}
