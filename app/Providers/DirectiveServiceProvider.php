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
        Blade::directive('usd', function ($cents) {
            return "<?php echo '$'.number_format(($cents / 100), 2, '.', ' '); ?>";
        });

        Blade::directive('uah', function ($cents) {
            return "<?php echo '₴'.number_format(($cents * 25 / 100), 2, '.', ' '); ?>";
        });
    }
}
