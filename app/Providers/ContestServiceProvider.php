<?php

namespace Gladiator\Providers;

use Carbon\Carbon;
use Gladiator\Models\Contest;
use Gladiator\Models\WaitingRoom;
use Illuminate\Support\ServiceProvider;

class ContestServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // Create a new waiting room when a Contest is saved.
        Contest::created(function ($contest) {
            $waitingRoom = new WaitingRoom;

            $waitingRoom->contest_id = $contest->getKey();

            // Default sign up period of one week.
            $waitingRoom->signup_start_date = Carbon::now();
            $waitingRoom->signup_end_date = Carbon::now()->addWeeks(1)->endOfDay();

            $waitingRoom->save();
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
