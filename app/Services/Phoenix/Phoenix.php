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
        $response = $this->get($this->base_uri . 'campaigns/' . $id);

        return is_null($response) ? null : $response;
    }

    /**
     * Send a GET request to return a reportback & an item with the specified id.
     *
     * @param  string $reportback_id
     * @param  string $reportback_item_id
     * @return object|null
     */
    public function getSpecificReportbackItem($reportback_id, $reportback_item_id)
    {
        $response = $this->get($this->base_uri . 'reportbacks/' . $reportback_id);

        // Remove the nonsense 0,1,2 array keys and key by the reportback item id.
        $reportback_items = collect($response->reportback_items->data)->keyBy('id');

        // Find the matching reportback item, and return the item.
        return $reportback_items->get($reportback_item_id);
    }
}
