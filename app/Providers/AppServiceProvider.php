<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Model::unguard();

        if (app()->environment('production')) {
            URL::forceScheme('https');
        }

        // Register observers
        \App\Models\Shop\Order::observe(\App\Observers\OrderObserver::class);

        // Share categories and brands to header
        view()->composer('partials.frontend.header', function ($view) {
            $headerCategories = \App\Models\Shop\Category::where('is_visible', true)
                ->withCount('products')
                ->having('products_count', '>', 0)
                ->orderBy('name')
                ->limit(10)
                ->get();

            $headerBrands = \App\Models\Shop\Brand::where('is_visible', true)
                ->withCount('products')
                ->having('products_count', '>', 0)
                ->orderBy('name')
                ->limit(10)
                ->get();

            $view->with([
                'headerCategories' => $headerCategories,
                'headerBrands' => $headerBrands
            ]);
        });
    }
}
