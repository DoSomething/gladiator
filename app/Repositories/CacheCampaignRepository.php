<?php

namespace Gladiator\Repositories;

use Gladiator\Repositories\CacheStorage;

class CacheCampaignRepository implements RepositoryContract
{
    use CacheStorage;

    public function find($id)
    {
        // stuff
    }

    public function getAll(array $ids = [])
    {
        // stuff
    }
}
