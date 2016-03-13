<?php

namespace Gladiator\Providers;

use Gladiator\Services\Registrar;
use Illuminate\Support\ServiceProvider;
use Gladiator\Repositories\CacheUserRepository;
use Gladiator\Repositories\DatabaseUserRepository;
use Gladiator\Repositories\UserRepositoryInterface;

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
        $this->app->bind(UserRepositoryInterface::class, function ($app) {
            return new CacheUserRepository(new DatabaseUserRepository);
        });
    }
}
