<?php

namespace Gladiator\Repositories;

use Illuminate\Support\Facades\Cache;
use Gladiator\Repositories\UserRepositoryInterface;

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

    public function getAllByRole($role)
    {
        // Need list of user NS ids to check the cache.
        $userIds = $this->database->getAllByRole('admin');

        // $users = Cache::many();
    }

    public function store($key, $data, $minutes = 15)
    {
        Cache::put($key, $data, $minutes);
    }
}
