<?php

namespace Gladiator\Services\Phoenix;

use Gladiator\Services\RestApiClient;

class Phoenix extends RestApiClient
{
    protected $base_uri;

    /**
     * Northstar constructor.
     */
    public function __construct()
    {
        $this->base_uri = config('services.phoenix.uri') . '/' . config('services.phoenix.version') . '/';

        $headers = [
           'Content-type' => 'application/json',
           'Accept' => 'application/json'
        ];

        parent::__construct($this->base_uri, $headers);
    }

    /**
     * Send a GET request to return user activity with the specified id.
     *
     * @param  string  $drupalId
     * @return object
     */
    public function getUserActivity($drupalId)
    {
        $response = $this->client->request('GET', $this->base_uri . 'signups', [
            'query' => [
                'uid' => $drupalId
            ]
        ]);

        dd($response->getBody());
        // return is_null($response) ? null : $response;
    }
}
