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
        $this->base_uri = config('services.phoenix.uri') . '/api/' . config('services.phoenix.version') . '/';

        $headers = [
           'Content-type' => 'application/json',
           'Accept' => 'application/json',
        ];

        parent::__construct($this->base_uri, $headers);
    }

    /**
     * Send a GET request to return a campaign.
     *
     * @param  int $ids
     * @return object
     */
    public function getCampaign($id)
    {
        $response = $this->get($this->base_uri . 'campaigns/' . $id);

        return is_null($response) ? null : $response;
    }

    public function getAllCampaigns($params = [])
    {
        $response = $this->get('campaigns', $params);

        return is_null($response) ? null : $response;
    }

}
