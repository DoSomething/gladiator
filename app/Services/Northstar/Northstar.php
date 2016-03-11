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
     * Send a GET request to return a collection of users.
     *
     * @param  int $limit
     * @param  int $page
     * @param  array  $filters
     * @param  array  $searches
     * @return object
     */
    public function getUsers($limit = null, $page = null, $filters = [], $searches = [])
    {
        $parameters = [];

        if ($limit) {
            $parameters['limit'] = $limit;
        }

        if ($page) {
            $parameters['page'] = $page;
        }

        if ($filters) {
            foreach ($filters as $key => $filter) {
                $parameters['filter[' . $key . ']'] = $filter;
            }
        }

        if ($searches) {
            foreach ($searches as $key => $search) {
                $parameters['search[' . $key . ']'] = $search;
            }
        }

        $response = $this->get('users', $parameters);

        return is_null($response) ? null : $response;
    }

    /**
     * Send a GET request to return a user with the specified id.
     *
     * @param  string  $type
     * @param  string  $id
     * @return object
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
}
