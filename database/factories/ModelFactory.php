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
        'northstar_id' => str_random(24),
        'role' => null,
    ];
});

// Contest Factory.
$factory->define(Contest::class, function (Generator $faker) {
    $phoenix = new Phoenix;

    $campaignIds = ['1247', '1663', '1581', '1593', '1467', '1334', '362', '46', '1650', '1560', '1222', '1667', '74', '1198', '886', '1492', '1503', '1376', '1665', '955', '31'];

    $campaign = $phoenix->getCampaign($campaignIds[array_rand($campaignIds)]);

    return [
        'campaign_id' => $campaign['data']['id'],
        'campaign_run_id' => $campaign['data']['campaign_runs']['current']['en']['id'],
        'sender_email' => $faker->safeEmail(),
        'sender_name' => $faker->name(),
    ];
});
