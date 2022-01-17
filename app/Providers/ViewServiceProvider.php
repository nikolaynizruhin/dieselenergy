<?php

namespace App\Providers;

use App\Http\View\Composers\Admin\BrandComposer;
use App\Http\View\Composers\Admin\CartComposer as AdminCartComposer;
use App\Http\View\Composers\Admin\ContactComposer;
use App\Http\View\Composers\Admin\DashboardComposer;
use App\Http\View\Composers\Admin\MediaComposer;
use App\Http\View\Composers\Admin\OrderComposer;
use App\Http\View\Composers\Admin\ProductComposer;
use App\Http\View\Composers\Admin\ProductsComposer;
use App\Http\View\Composers\Admin\SpecificationComposer;
use App\Http\View\Composers\CartComposer;
use App\Http\View\Composers\CategoryComposer;
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
        View::composer('layouts.app', CategoryComposer::class);

        // Admin
        View::composer(['admin.products.create', 'admin.products.edit'], ProductComposer::class);

        View::composer(['admin.orders.create', 'admin.orders.edit'], OrderComposer::class);

        View::composer(['admin.contacts.create', 'admin.contacts.edit'], ContactComposer::class);

        View::composer(['admin.carts.create', 'admin.carts.edit'], AdminCartComposer::class);

        View::composer(['admin.specifications.create', 'admin.specifications.edit'], SpecificationComposer::class);

        View::composer(['admin.brands.create', 'admin.brands.edit', 'admin.brands.index'], BrandComposer::class);
    }
}
