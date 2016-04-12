<?php

namespace Gladiator\Repositories;

use Gladiator\Services\Phoenix\Phoenix;

class CacheCampaignRepository implements RepositoryContract
{
    use CacheStorage;

    protected $prefix = 'campaign';

    /**
     * Create new CacheCampaignRepository instance.
     */
    public function __construct()
    {
        $this->phoenix = new Phoenix;
    }

    /**
     * Find the specified campaign in cache or default to api request.
     *
     * @param  string  $id
     * @return object|null
     */
    public function find($id)
    {
        $key = $this->setPrefix($id, $this->prefix);

        $campaign = $this->retrieve($key);

        if (! $campaign) {
            // @see https://github.com/DoSomething/gladiator/issues/180
            $campaign = $this->phoenix->getCampaign($id);

            $this->store($key, $campaign);
        }

        return $campaign;
    }

    public function getAll(array $ids = [])
    {
        dd($ids);
    }
}

// # Notes
// Make the $minutes a protected property of the trait so it can be overridden
// if we want to have User cache last 15 min but Campaign cache last 60 min.
