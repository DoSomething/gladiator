<?php

namespace Gladiator\Repositories;

interface RepositoryContract
{
    /**
     * Find the specified resource in the repository.
     *
     * @param  string  $id
     * @return object
     */
    public function find($id);

    /**
     * Get collection of all resources or set of resources by ids.
     *
     * @param  array  $ids
     * @return \Illuminate\Support\Collection
     */
    public function getAll(array $ids = []);
}
