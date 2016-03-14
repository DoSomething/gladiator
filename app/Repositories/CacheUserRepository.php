<?php

namespace Gladiator\Repositories;

use Illuminate\Support\Facades\Cache;

class CacheUserRepository implements UserRepositoryInterface
{
    protected $database;

    public function __construct(UserRepositoryInterface $database)
    {
        $this->database = $database;
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

    public function getAll()
    {
        $users = Cache::get('users');
        // $users = Cache::many('users');

        if (! $users) {
            $users = $this->database->getAll();
        }

        return $users;
    }

    /**
     * Get collection of users from cache by specified role or default to database lookup.
     *
     * @param  string $role
     * @return \Illuminate\Support\Collection
     */
    public function getAllByRole($role)
    {
        $key = $role ? $role : 'contestant';

        $ids = $this->retrieve($key . ':ids');

        if ($ids) {
            $users = $this->retrieveMany($ids);
            // @TODO: Need to check results:
            // if any are "false" (thus no longer in cache),
            // need to manually grab that item from NS.
            // $this->resolveMissingUsers();
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

    public function update($request, $id)
    {
        $user = $this->database->update($request, $id);

        $this->forget($user->id);

        return $user;
    }

    protected function forget($key)
    {
        Cache::forget($key);
    }

    protected function flush()
    {
        Cache::flush();
    }

    protected function retrieve($key)
    {
        return Cache::get($key);
    }

    protected function retrieveMany(array $keys)
    {
        return Cache::many($keys);
    }

    protected function store($key, $value, $minutes = 15)
    {
        Cache::put($key, $value, $minutes);
    }

    protected function storeMany(array $values, $minutes = 15)
    {
        Cache::putMany($values, $minutes);
    }
}
