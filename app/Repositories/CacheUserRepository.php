<?php

namespace Gladiator\Repositories;

use Gladiator\Models\User;
use Illuminate\Support\Facades\Cache;

class CacheUserRepository implements UserRepositoryContract
{
    /**
     * UserRepositoryContract instance.
     *
     * @var \Gladiator\Repositories\UserRepositoryContract
     */
    protected $repository;

    /**
     * Create new CacheUserRepository instance.
     *
     * @param UserRepositoryContract $repository
     */
    public function __construct(UserRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Create and cache a new user.
     *
     * @param  object  $account
     * @return \Gladiator\Models\User
     */
    public function create($account)
    {
        $user = $this->repository->create($account);

        $this->resolveUpdatedRoles($user->id, $user->role);

        return $user;
    }

    /**
     * Find the specified resource in cache or default to alternate repository
     * lookup.
     *
     * @param  string  $id  Northstar ID
     * @return object
     */
    public function find($id)
    {
        $user = Cache::get($id);

        if (! $user) {
            $user = $this->repository->find($id);

            $this->store($user->id, $user);
        }

        return $user;
    }

    /**
     * Get collection of all users or set of users by ids from cache or
     * default to alternate respository lookup.
     *
     * @param  array $ids Northstar IDs
     * @return \Illuminate\Support\Collection
     */
    public function getAll(array $ids = [])
    {
        // @TODO: This is messy and needs another pass.
        if ($ids) {
            $users = $this->retrieveMany($ids);

            if (! $users) {
                $users = $this->repository->getAll($ids);

                if ($users->count()) {
                    $group = $users->keyBy('id')->all();
                    $this->storeMany($group);
                }
            } else {
                $users = $this->resolveMissingUsers($users);
                $users = collect(array_values($users));
            }

            return $users;
        }

        // @TODO: find a better way to retrieve all from cache.
        // Will resort to just passing off to alternate repository
        // and grabbing everything from Northstar without caching.
        $users = $this->repository->getAll();

        return $users;
    }

    /**
     * Get collection of users from cache by specified role or default to
     * alternate repository lookup.
     *
     * @param  string|null $role
     * @return \Illuminate\Support\Collection
     */
    public function getAllByRole($role = null)
    {
        $key = array_search($role, User::getRoles());

        $ids = $this->retrieve($key . ':ids');

        if ($ids) {
            $users = $this->retrieveMany($ids);
            $users = $this->resolveMissingUsers($users);
            $users = collect(array_values($users));

            return $users;
        }

        $users = $this->repository->getAllByRole($role);

        if ($users->count()) {
            $ids = $users->pluck('id')->toArray();
            $collection = collect($users)->keyBy('id')->toArray();

            $this->store($key . ':ids', $ids);
            $this->storeMany($collection);
        }

        return $users;
    }

    /**
     * Update the specified user's data and resolve the cache.
     *
     * @param  \Gladiator\Http\Requests\UserRequest $request
     * @param  string $id  Northstar ID
     * @return object
     */
    public function update($request, $id)
    {
        $user = $this->repository->update($request, $id);

        $this->resolveUpdatedRoles($id, $request->role);

        return $user;
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
     * Remove all items from the cache.
     *
     * @return void
     */
    protected function flush()
    {
        Cache::flush();
    }

    /**
     * Parse through cached role ids, and update for specified user.
     *
     * @param  string $id  Northstar ID
     * @param  string $role
     * @return void
     */
    protected function resolveUpdatedRoles($id, $role)
    {
        foreach (User::getRoles() as $name => $value) {
            $key = $name . ':ids';
            $ids = $this->retrieve($key);

            if ($ids) {
                if (in_array($id, $ids)) {
                    unset($ids[array_search($id, $ids)]);

                    $this->forget($key);
                    $this->store($key, $ids);
                } else {
                    if ($name === $role) {
                        $this->forget($key);

                        $ids[] = $id;

                        $this->store($key, $ids);
                    }
                }
            }
        }
    }

    /**
     * Resolving missing cached users in a user cache collection.
     *
     * @param  array $users
     * @return array
     */
    protected function resolveMissingUsers($users)
    {
        foreach ($users as $key => $value) {
            if ($value === false or $value === null) {
                $users[$key] = $this->find($key);
            }
        }

        return $users;
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
     *
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
    protected function store($key, $value, $minutes = 15)
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
    protected function storeMany(array $values, $minutes = 15)
    {
        Cache::putMany($values, $minutes);
    }
}
