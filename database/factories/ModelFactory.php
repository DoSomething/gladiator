<?php

use Faker\Generator;
use Gladiator\Models\User;
use Gladiator\Models\Contest;

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

// User Factory.
$factory->define(User::class, function (Generator $faker) {
    return [
        'id' => str_random(24),
        'role' => null,
    ];
});

// Contest Factory.
$factory->define(Contest::class, function (Generator $faker) {
    return [
        'campaign_id' => $faker->numberBetween(10, 300),
        'campaign_run_id' => $faker->numberBetween(1000, 3000),
        'duration' => $faker->randomElement([30, 60, 365]),
    ];
});
