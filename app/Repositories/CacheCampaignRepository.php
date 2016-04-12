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
        $key = $this->setPrefix($id);

        $campaign = $this->retrieve($key);

        if (! $campaign) {
            // @see https://github.com/DoSomething/gladiator/issues/180
            $campaign = $this->phoenix->getCampaign($id);

            $this->store($key, $campaign);
        }

        return $campaign;
    }

    /**
     * Get collection of all campaigns or a set of campaigns by ids from cache or
     * default to api request.
     *
     * @param  array  $ids
     * @return \Illuminate\Support\Collection
     */
    public function getAll(array $ids = [])
    {
        if ($ids) {
            $keys = array_map([$this, 'setPrefix'], $ids);

            $campaigns = $this->retrieveMany($keys);

            if (! $campaigns) {
                $parameters['ids'] = implode(',', $ids);

                $campaigns = $this->phoenix->getAllCampaigns($parameters);
                $campaigns = collect($campaigns);

                if ($campaigns) {
                    $group = $campaigns->keyBy(function ($item) {
                        return $this->setPrefix($item->id);
                    })->all();

                    $this->storeMany($group);
                }
            } else {
                $campaigns = $this->resolveMissingItems($campaigns);
                $campaigns = collect(array_values($campaigns));
            }

            return $campaigns;
        }

        // @TODO: not sure if the following is actually a thing that is possible.
        // $campaigns = $this->phoenix->getAllCampaigns(['count' => 'all']);
        return null;
    }
}

// # Notes
// Make the $minutes a protected property of the trait so it can be overridden
// if we want to have User cache last 15 min but Campaign cache last 60 min.
