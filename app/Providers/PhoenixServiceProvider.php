<?php

namespace Gladiator\Providers;

use Gladiator\Services\Phoenix\Phoenix;
use Illuminate\Support\ServiceProvider;

class PhoenixServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('phoenix', function ($app) {
            return new Phoenix();
        });
    }
}
