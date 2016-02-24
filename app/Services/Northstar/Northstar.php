<?php

namespace Gladiator\Services\Northstar;

use Gladiator\Services\RestApiClient;

class Northstar extends RestApiClient
{
    /**
     * Northstar constructor.
     */
    public function __construct()
    {
        $base_uri = config('services.northstar.uri') . '/' . config('services.northstar.version') . '/';

        $headers = [
            'X-DS-REST-API-Key' => config('services.northstar.api_key'),
        ];

        parent::__construct($base_uri, $headers);
    }

    /**
     * Send a GET request to return a user with the specified id.
     *
     * @param  string  $id
     * @param  string  $type
     * @return object
     */
    public function getUser($id, $type = 'email')
    {
        $response = $this->get('users/' . $type . '/' . $id);

        return is_null($response) ? null : $response;
    }

    /**
     * Send a POST request to verify user with specified credentials.
     *
     * @param  object $credentials
     * @return bool
     */
    public function verifyUser($credentials)
    {
        $response = $this->post('auth/verify', $credentials);

        return $response ? true : false;
    }
}
