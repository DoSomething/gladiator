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
    protected $database;

    /**
     * Create new CacheUserRepository instance.
     *
     * @param UserRepositoryContract $database
     */
    public function __construct(UserRepositoryContract $database)
    {
        $this->database = $database;
    }

    /**
     * Create and cache a new user.
     *
     * @param  object  $account
     * @return object
     */
    public function create($account)
    {
        $user = $this->database->create($account);

        $this->resolveUpdatedRoles($user->id, $user->role);

        $user = $this->find($user->id);

        return $user;
    }

    /**
     * Find the specified resource in cache or default to database lookup.
     *
     * @param  string  $id  Northstar ID
     * @return object
     */
    public function find($id)
    {
        $user = Cache::get($id);

        if (! $user) {
            $user = $this->database->find($id);

            $this->store($user->id, $user);
        }

        return $user;
    }

    /**
     * Get collection of users from cache by specified role or default to database lookup.
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

        $users = $this->database->getAllByRole($role);

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
        $user = $this->database->update($request, $id);

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
            if ($value === false) {
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
     * @return array
     */
    protected function retrieveMany(array $keys)
    {
        return Cache::many($keys);
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
