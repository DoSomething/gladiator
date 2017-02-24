<?php

namespace Gladiator\Services\Northstar;

use DoSomething\Gateway\Common\RestApiClient;

class Northstar extends RestApiClient
{
    /**
     * Northstar constructor.
     */
    public function __construct()
    {
        $base_uri = config('services.northstar.url') . '/' . config('services.northstar.version') . '/';

        parent::__construct($base_uri);
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

    /**
     * Send a GET request to return all signups for the supplied collection of users.
     *
     * @param  array  $inputs
     * @return object|null
     */
    public function getAllUserSignups($inputs = [])
    {
        $response = $this->get('signups', $inputs);

        return is_null($response) ? null : $response;
    }

    /*
     * Send a GET request to return a user's signups.
     *
     * @param  array  $inputs
     * @return object|null
     */
    public function getUserSignups($inputs = [])
    {
        $response = $this->get('signups', $inputs);

        return is_null($response) ? null : $response;
    }
}
