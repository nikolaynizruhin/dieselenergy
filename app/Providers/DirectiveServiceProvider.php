<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class DirectiveServiceProvider extends ServiceProvider
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
        Blade::directive('uah', fn ($price) => "<?= number_format($price / 100, 0, '.', ' ').' ₴'; ?>");

        Blade::directive('markdown', fn ($content) => "<?= Str::markdown($content) ?>");
    }
}
