<?php

namespace Gladiator\Http\Controllers\Traits;

trait FiltersRequests
{
    /**
     * Create a new query builder from the given Eloquent class, which can then be
     * filtered, searched, and/or paginated.
     *
     * @param string $class - Eloquent model class name
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function newQuery($class)
    {
        return (new $class)->newQuery();
    }

    /**
     * Limit results to users exactly matching a set of filters.
     *
     * @param $query
     * @param $filters
     * @param $indexes - Indexed fields (whitelisted for filtering)
     * @return mixed
     */
    public function filter($query, $filters, $indexes)
    {
        if (! $filters) {
            return $query;
        }

        // If there is an exclude filter, remove it from $filters and save the value.
        if (array_key_exists('exclude', $filters)) {
            $excludedValues = $filters['exclude'];
            unset($filters['exclude']);
        } else {
            $excludedValues = false;
        }

        // If there is an updated_at param, remove it from $filters and save the value.
        if (array_key_exists('updated_at', $filters)) {
            $updatedAtValue = $filters['updated_at'];
            unset($filters['updated_at']);
        } else {
            $updatedAtValue = false;
        }

        // Requests may be filtered by indexed fields.
        $filters = array_intersect_key($filters, array_flip($indexes));

        // You can filter by multiple values, e.g. `filter[source]=agg,cgg`
        // to get records that have a source value of either `agg` or `cgg`.
        foreach ($filters as $filter => $values) {
            $values = explode(',', $values);
            if (count($values) > 1) {
                // For the first `where` query, we want to limit results... from then on,
                // we want to append (e.g. `SELECT * (WHERE _ OR WHERE _ OR WHERE _)` and (WHERE _ OR WHERE _))
                $query->where(function ($query) use ($values, $filter) {
                    foreach ($values as $value) {
                        $query->orWhere($filter, $value);
                    }
                });
            } else {
                $query->where($filter, $values[0], 'and');
            }
        }

        if ($updatedAtValue) {
            $query->where('updated_at', '>', $updatedAtValue);
        }

        if ($excludedValues) {
            // @TODO - Only excludes `id` fields, we could update this to be more flexible.
            $query->whereNotIn('id', explode(',', $excludedValues));
        }

        return $query;
    }
}
