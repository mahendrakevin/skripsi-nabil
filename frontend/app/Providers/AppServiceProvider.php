<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('convert', function ($money) {
            return "<?php echo number_format($money, 2); ?>";
        });

        Gate::define('admin', function () {
            if (auth()->user()->role == 1) {
                return true;
            }
            return false;
        });
        Gate::define('bendahara', function () {
            if (auth()->user()->role == 2) {
                return true;
            }
            return false;
        });
        Gate::define('kepsek', function () {
            if (auth()->user()->role == 3) {
                return true;
            }
            return false;
        });
    }
}
