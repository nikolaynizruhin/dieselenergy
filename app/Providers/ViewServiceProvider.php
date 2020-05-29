<?php

namespace App\Providers;

use App\Http\View\Composers\CartComposer;
use App\Http\View\Composers\DashboardComposer;
use App\Http\View\Composers\OrderComposer;
use App\Http\View\Composers\ProductComposer;
use App\Http\View\Composers\ProductsComposer;
use App\Http\View\Composers\SpecificationComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer(
            ['dashboard'],
            DashboardComposer::class
        );

        View::composer(
            ['products.index'],
            ProductsComposer::class
        );

        View::composer(
            ['products.create', 'products.edit'],
            ProductComposer::class
        );

        View::composer(
            ['orders.create', 'orders.edit'],
            OrderComposer::class
        );

        View::composer(
            ['carts.create', 'carts.edit'],
            CartComposer::class
        );

        View::composer(
            ['specifications.create'],
            SpecificationComposer::class
        );
    }
}
