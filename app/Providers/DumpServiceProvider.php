<?php

namespace App\Providers;

use App\Services\Dump\Dumper;
use App\Services\Dump\DumperFactory;
use Illuminate\Support\ServiceProvider;

class DumpServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Dumper::class, function ($app) {
            $config = $app['db.connection']->getConfig();

            return DumperFactory::make($config);
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
