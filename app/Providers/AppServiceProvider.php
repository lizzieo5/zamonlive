<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use App\Models\Category;

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
     * Bootstrap any application services. language uchun
     */
    public function boot(){
        if (Session::has('locale')) {
            App::setLocale(Session::get('locale'));
        }

        // View Composer для глобального доступа к категориям
        View::composer('*', function ($view) {
            $view->with('navCategories', Category::orderBy('name')->get());
        });
    }

}