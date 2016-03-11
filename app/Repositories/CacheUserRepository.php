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

    public function find($id)
    {
        $user = Cache::get($id);

        if (! $user) {
            $user = $this->database->find($id);
        }

        return $user;
    }

    public function getAll()
    {
        $users = Cache::get('users');

        if (! $users) {
            $users = $this->database->getAll();
        }

        return $users;
    }

    public function getAllByRole($role)
    {

    }

    public function store($key, $data)
    {
        Cache::put($key, $data, 2);
    }
}
