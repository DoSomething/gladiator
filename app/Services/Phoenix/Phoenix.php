<?php

namespace Gladiator\Services\Phoenix;

use DoSomething\Gateway\Common\RestApiClient;

class Phoenix extends RestApiClient
{
    use AuthorizesWithDrupal;

    /*
     * Phoenix API base uri.
     */
    protected $base_uri;

    /**
     * Phoenix constructor.
     */
    public function __construct()
    {
        $this->base_uri = config('services.phoenix.uri') . '/api/' . config('services.phoenix.version') . '/';

        parent::__construct($this->base_uri);
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

    /**
     * Get an index of (optionally filtered) campaign signups from Phoenix.
     * @see: https://github.com/DoSomething/phoenix/wiki/API#retrieve-a-signup-collection
     *
     * @param array $query - query string, for filtering results
     * @return array - JSON response
     */
    public function getAllSignups(array $query = [])
    {
        $path = 'signups';

        // Avoid caching when requesting signups for sepcific user and campaign.
        // @Temporary?
        if (isset($query['campaigns']) && isset($query['users'])) {
            return $this->get($path, $query);
        }

        return $this->get($path, $query);
    }

    /**
     * Get details for a particular campaign signup from Phoenix.
     * @see: https://github.com/DoSomething/phoenix/wiki/API#retrieve-a-specific-signup
     *
     * @return array - JSON response
     */
    public function getSignup($signup_id)
    {
        $path = 'signups/'.$signup_id;

        return $this->get($path);
    }

    /**
     * Get an index of (optionally filtered) campaign reportbacks from Phoenix.
     * @see: https://github.com/DoSomething/phoenix/wiki/API#retrieve-a-reportback-collection
     *
     * @param array|string $query - query string, for filtering results
     * @return array - JSON response
     */
    public function getAllReportbacks(array $query = [])
    {
        $path = 'reportbacks';
        $query['load_user'] = true;
        if (auth()->id()) {
            $query['as_user'] = auth()->id();
        }

        return $this->get($path, $query);
    }
}
