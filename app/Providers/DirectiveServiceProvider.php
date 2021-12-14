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
        Blade::directive('uah', fn ($price) => "<?php echo number_format($price, 0, '.', ' ').' ₴'; ?>");

        Blade::directive('markdown', fn ($content) => "<?php echo Str::markdown($content) ?>");
    }
}
