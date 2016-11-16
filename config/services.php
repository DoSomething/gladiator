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
    //     'uri' => env('NORTHSTAR_URI'),
    //     'version' => 'v1',
    //     'api_key' => env('NORTHSTAR_API_KEY'),
    // ],

    'northstar' => [
        'grant' => 'client_credentials', // Default OAuth grant to use: either 'authorization_code' or 'client_credentials'
        'url' => 'http://northstar-qa.dosomething.org', // the environment you want to connect to
        'version' => 'v1',
        
        // Then, configure client ID, client secret, and scopes per grant.
        'client_credentials' => [
            'client_id' => 'phoenix-qa',
            'client_secret' => 'O5SQ0S4DU6Qyj6Lnp1LKbAduvhU2RvKk',
            'scope' => ['admin'],
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
