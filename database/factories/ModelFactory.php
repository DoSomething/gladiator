<?php

use Faker\Generator;
use Gladiator\Models\User;
use Gladiator\Models\Contest;
use Gladiator\Services\Phoenix\Phoenix;

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

    $phoenix = new Phoenix;

    $campaignIds = ['1485', '1283', '1631'];

    $campaign = $phoenix->getCampaign($campaignIds[array_rand($campaignIds)]);

    return [
        'campaign_id' => $campaign->id,
        'campaign_run_id' => $campaign->campaign_runs->current->en->id,
        'sender_email' => $faker->safeEmail(),
        'sender_name' => $faker->name(),
    ];
});
