<?php

namespace App\Providers;

use App\Http\View\Composers\Admin\CartComposer;
use App\Http\View\Composers\Admin\DashboardComposer;
use App\Http\View\Composers\Admin\MediaComposer;
use App\Http\View\Composers\Admin\OrderComposer;
use App\Http\View\Composers\Admin\ProductComposer;
use App\Http\View\Composers\Admin\ProductsComposer;
use App\Http\View\Composers\Admin\SpecificationComposer;
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
            ['admin.dashboard'],
            DashboardComposer::class
        );

        View::composer(
            ['admin.products.index'],
            ProductsComposer::class
        );

        View::composer(
            ['admin.products.create', 'admin.products.edit'],
            ProductComposer::class
        );

        View::composer(
            ['admin.orders.create', 'admin.orders.edit'],
            OrderComposer::class
        );

        View::composer(
            ['admin.carts.create', 'admin.carts.edit'],
            CartComposer::class
        );

        View::composer(
            ['admin.medias.create'],
            MediaComposer::class
        );

        View::composer(
            ['admin.specifications.create', 'admin.specifications.edit'],
            SpecificationComposer::class
        );
    }
}
