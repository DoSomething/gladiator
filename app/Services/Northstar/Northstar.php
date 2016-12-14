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
        $base_uri = config('services.northstar.url') . '/' . config('services.northstar.version') . '/';
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
        $response = $this->rewriteMultipleKeys($response);

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
        $response = $this->rewriteKeys($response);

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

    /**
     * Rewrites 'id' keys in northstar response to 'northstar_id' of multiple users.
     *
     * @param  object|null
     * @return arr
     */
    public function rewriteMultipleKeys($usersResponse)
    {
        $newArr = [];

        foreach ($usersResponse as $user) {
            $userArr = [];
            $newArr[] = $this->rewriteKeys($user);
        }

        return $newArr;
    }

    /**
     * Rewrites 'id' keys in northstar response to 'northstar_id' of a single users.
     *
     * @param  object|null
     * @return arr
     */
    public function rewriteKeys($userResponse)
    {
        $rewriteKeys = ['id' => 'northstar_id', '_id' => '_northstar_id'];
        $newUserArr = [];

        foreach ($userResponse as $key => $value) {
            if ($key == 'id' || $key == '_id') {
                $newUserArr [$rewriteKeys [$key ]] = $value;
            } else {
                $newUserArr[$key] = $value;
            }
        }

        return json_decode(json_encode($newUserArr), false);
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
