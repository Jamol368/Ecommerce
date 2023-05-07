<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\MainCategory;
use App\Models\Product;
use Illuminate\Support\ServiceProvider;

class ContentServiceProvider extends ServiceProvider
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
        $this->menu_items = Category::where('parent_id', null)->take(4)->get();
        $this->new_products = Product::take(4)->get();

        view()->composer('layouts.app', function($view) {
            $view->with(['contents' => $this->menu_items, 'new_products' => $this->new_products]);
        });
    }
}
