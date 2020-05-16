<?php

namespace App\Providers;

use App\Http\View\Composers\ProductComposer;
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
            ['products.create', 'products.edit'],
            ProductComposer::class
        );

        View::composer(
            ['specifications.create'],
            SpecificationComposer::class
        );
    }
}
