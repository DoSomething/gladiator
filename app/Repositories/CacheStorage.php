<?php

namespace Gladiator\Repositories;

use Illuminate\Support\Facades\Cache;

trait CacheStorage
{
    /**
     * Remove all items from the cache.
     *
     * @return void
     */
    protected function flush()
    {
        Cache::flush();
    }

    /**
     * Remove an item from the cache.
     *
     * @param  string  $key
     * @return void
     * @TODO: Might be best to return a bool like the Laravel class does?
     */
    protected function forget($key)
    {
        Cache::forget($key);
    }

    /**
     * Retrieve an item from the cache by key.
     *
     * @param  string  $key
     * @return mixed
     */
    protected function retrieve($key)
    {
        return Cache::get($key);
    }

    /**
     * Retrieve multiple items from the cache by key.
     * Items not found in the cache will have a null value.
     *
     * @param  array  $keys
     * @return array|null
     */
    protected function retrieveMany(array $keys)
    {
        $retrieved = [];

        $data = Cache::many($keys);

        foreach ($data as $item) {
            if ($item) {
                $retrieved[] = $item;
            }
        }

        if (count($retrieved)) {
            return $data;
        }
    }

    /**
     * Store an item in the cache for a given number of minutes.
     *
     * @param  string  $key
     * @param  mixed   $value
     * @param  int     $minutes
     * @return void
     */
    protected function store($key, $value, $minutes = 2)
    {
        Cache::put($key, $value, $minutes);
    }

    /**
     * Store multiple items in the cache for a given number of minutes.
     *
     * @param  array  $values
     * @param  int  $minutes
     * @return void
     */
    protected function storeMany(array $values, $minutes = 2)
    {
        Cache::putMany($values, $minutes);
    }
}
