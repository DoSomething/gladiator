<?php

use Faker\Generator;
use Gladiator\Models\User;
use Gladiator\Models\WaitingRoom;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(User::class, function (Generator $faker) {
    return [
        'id' => str_random(24),
        'role' => null,
    ];
});

$factory->define(WaitingRoom::class, function (Generator $faker) {
    return [
        'campaign_id' => $faker->numberBetween(10, 300),
        'campaign_run_id' => $faker->numberBetween(1000, 3000),
        'signup_start_date' => $faker->dateTimeBetween('-3 weeks', 'now'),
        'signup_end_date' => $faker->dateTimeBetween('now', '+3 weeks'),
    ];
});

