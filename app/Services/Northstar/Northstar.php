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
     * Send a GET request to return all users matching a given query.
     *
     * @param  array $inputs - Filter, search, limit or pagination queries
     * @return object|null
     * @see  https://github.com/DoSomething/northstar/blob/dev/documentation/endpoints/users.md#retrieve-all-users
     */
    public function getAllUsers($inputs = [])
    {
        $response = $this->get('users', $inputs);

        return is_null($response) ? null : $response;
    }

    /**
     * Send a GET request to return a user with the specified id.
     *
     * @param  string  $type
     * @param  string  $id
     * @return object|null
     */
    public function getUser($type, $id)
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

    /*
     * Send a GET request to return a user's signups.
     *
     * @param  string $ids
     * @param  string $campaigns
     * @param  int|array $runs
     * @return object|null
     */
    public function getUserSignups($ids, $campaigns, $runs = '')
    {
        $response = $this->get('signups', [
            'users' => $ids,
            'campaigns' => $campaigns,
            'runs' => $runs,
        ]);

        return is_null($response) ? null : $response;
    }
}
