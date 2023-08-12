<?php

namespace App\Providers;

use App\Services\Dump\Dumper;
use App\Services\Dump\DumperFactory;
use Illuminate\Support\ServiceProvider;

class DumpServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(Dumper::class, function ($app) {
            $config = $app['db.connection']->getConfig();

            return DumperFactory::make($config);
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
