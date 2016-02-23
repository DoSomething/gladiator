<?php

namespace Gladiator\Northstar;

use Gladiator\Services\RestApiClient;

class Northstar extends RestApiClient
{
    public function __construct()
    {
        $base_uri = config('services.northstar.uri') . '/' . config('services.northstar.version') . '/';

        $headers = [
            'X-DS-REST-API-Key' => config('services.northstar.api_key'),
        ];

        parent::__construct($base_uri, $headers);
    }

    public function getUser($id, $type = 'email')
    {
        $response = $this->get('users/' . $type . '/' . $id);

        dd($response);
    }
}
