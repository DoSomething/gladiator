<?php

namespace Gladiator\Providers;

use DoSomething\Gateway\Northstar;
use Illuminate\Support\ServiceProvider;
use Gladiator\Repositories\CacheUserRepository;
use Gladiator\Repositories\DatabaseUserRepository;
use Gladiator\Repositories\UserRepositoryContract;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserRepositoryContract::class, function ($app) {
            return new CacheUserRepository(
                new DatabaseUserRepository(
                    $app[Northstar::class]
                )
            );
        });
    }
}
