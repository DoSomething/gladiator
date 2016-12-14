<?php

namespace Gladiator\Providers;

use Illuminate\Support\ServiceProvider;
use Gladiator\Services\Northstar\Northstar;

class NorthstarServiceProvider extends ServiceProvider
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
        $this->app->singleton('northstar', function ($app) {
            return new Northstar();
        });
    }
}
