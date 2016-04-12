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
     * Resolving missing cached items in cache collection.
     *
     * @param  array $items
     * @return array
     */
    protected function resolveMissingItems($items)
    {
        // @TODO: maybe this should run in the retrieveMany() method?
        // @TODO: May want to check if calling Class has find() method using method_exists($object, $method_name).
        // @TODO: Might also be faster to collect the missing items and do a getAll() instead of find() for each individually.

        foreach ($items as $key => $value) {
            if ($value === false || $value === null) {
                if (property_exists($this, 'prefix')) {
                    $id = $this->unsetPrefix($key);
                }

                $items[$key] = $this->find($id);
            }
        }

        return $items;
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
     * Set a prefix on supplied string used as cache key.
     *
     * @param  string  $string
     * @return string
     */
    protected function setPrefix($string)
    {
        if (property_exists($this, 'prefix')) {
            return $this->prefix . ':' . $string;
        } else {
            return $string;
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

    /**
     * Unset a prefix on supplied string used as cache key.
     *
     * @param  string  $string
     * @return string
     */
    protected function unsetPrefix($string)
    {
        if (property_exists($this, 'prefix')) {
            return str_replace('campaign:', '', $string);
        } else {
            return $string;
        }
    }
}
