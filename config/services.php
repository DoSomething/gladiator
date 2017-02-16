<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, Mandrill, and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    // 'northstar' => [
        // 'uri' => env('NORTHSTAR_URI'),
        // 'version' => 'v1',
        // 'api_key' => env('NORTHSTAR_API_KEY'),
    // ],

    'northstar' => [
        // @TODO - Used for api calls for now. Remove this and use gateway for API calls.
        'uri' => env('NORTHSTAR_URI'),
        'version' => 'v1',
        'api_key' => env('NORTHSTAR_API_KEY'),

        'grant' => 'client_credentials',
        'url' => env('NORTHSTAR_URL'), // the environment you want to connect to

        // Then, configure client ID, client secret, and scopes per grant.
        'client_credentials' => [
            'client_id' => env('NORTHSTAR_CLIENT_ID'),
            'client_secret' => env('NORTHSTAR_CLIENT_SECRET'),
            'scope' => ['user'],
        ],
        'authorization_code' => [
            'client_id' => env('NORTHSTAR_AUTH_ID'),
            'client_secret' => env('NORTHSTAR_AUTH_SECRET'),
            'scope' => ['user'],
            'redirect_uri' => 'login',
        ],
    ],

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'mandrill' => [
        'secret' => env('MANDRILL_SECRET'),
    ],

    'phoenix' => [
        'uri' => env('PHOENIX_URI'),
        'version' => env('PHOENIX_API_VERSION'),
    ],

    'ses' => [
        'key'    => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'stripe' => [
        'model'  => Gladiator\Models\User::class,
        'key'    => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

];
