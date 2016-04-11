<?php

namespace Gladiator\Repositories;

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
