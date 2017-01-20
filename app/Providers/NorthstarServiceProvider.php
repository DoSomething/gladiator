<?php

namespace Gladiator\Providers;

use Gladiator\Services\Northstar\Northstar;
use Illuminate\Support\ServiceProvider;

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
