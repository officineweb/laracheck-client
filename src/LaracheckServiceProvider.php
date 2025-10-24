<?php

namespace Laracheck\Client;

use Illuminate\Support\ServiceProvider;

class LaracheckServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/laracheck.php' => config_path('laracheck.php'),
            ], 'laracheck-config');
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/laracheck.php', 'laracheck');

        $this->app->singleton('laracheck', function () {
            return new LaracheckTracker;
        });
    }
}
