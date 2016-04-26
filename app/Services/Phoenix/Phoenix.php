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
     * Send a GET request to return all campaigns matching a given query.
     *
     * @param  array  $params
     * @return object|null
     */
    public function getAllCampaigns($params = [])
    {
        $response = $this->get('campaigns', $params);

        return is_null($response) ? null : $response;
    }

    /**
     * Send a GET request to return a campaign with the specified id.
     *
     * @param  string $id
     * @return object|null
     */
    public function getCampaign($id)
    {
        $response = $this->get('campaigns/' . $id);

        return is_null($response) ? null : $response;
    }

    /**
     * Send a GET request to return a reportback & an item with the specified id.
     *
     * @param  string $reportback_id
     * @param  string $reportback_item_id
     * @return object|null
     */
    public function getReportback($reportback_id, $reportback_item_id)
    {
        return $this->get('reportbacks/' . $reportback_id);
    }
}
