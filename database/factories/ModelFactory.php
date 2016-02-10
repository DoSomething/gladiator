<?php

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

$factory->define(Gladiator\Models\User::class, function (Faker\Generator $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->email,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(Gladiator\Models\Contestant::class, function (Faker\Generator $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->email,
        'dosomething_id' => $faker->numberBetween(1000, 9000),
    ];
});

$factory->define(Gladiator\Models\Competition::class, function (Faker\Generator $faker) {
    return [
        'start_date' => $faker->dateTimeBetween('-5 weeks', 'now'),
        'end_date' => $faker->dateTimeBetween('now', '+10 weeks'),
        'campaign_run_id' => $faker->numberBetween(10, 300),
    ];
});
