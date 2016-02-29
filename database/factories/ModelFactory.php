<?php

use Faker\Generator;
use Gladiator\Models\User;
use Gladiator\Models\WaitingRoom;
use Gladiator\Models\Competition;

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
        'signup_start_date' => $faker->dateTimeBetween('-7 days', '-1 day'),
        'signup_end_date' => $faker->dateTimeBetween('+1 day', '+7 days'),
    ];
});

$factory->define(Competition::class, function (Generator $faker) {
    return [
        'campaign_id' => $faker->numberBetween(10, 300),
        'campaign_run_id' => $faker->numberBetween(1000, 3000),
        'start_date' => $faker->dateTimeBetween('-7 days', '-1 day'),
        'end_date' => $faker->dateTimeBetween('+1 day', '+7 days'),
    ];
});
