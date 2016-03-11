<?php

namespace Gladiator\Services;

use Gladiator\Models\User;
use Gladiator\Services\Northstar\Northstar;
use Gladiator\Repositories\UserRepositoryInterface;
use Gladiator\Services\Northstar\Exceptions\NorthstarUserNotFoundException;

class Registrar
{
    /**
     * Northstar instance.
     *
     * @var \Gladiator\Services\Northstar\Northstar
     */
    protected $northstar;

    protected $repository;

    /**
     * Create new Registrar instance.
     *
     * @param Northstar $northstar
     */
    public function __construct(Northstar $northstar, UserRepositoryInterface $repository)
    {
        $this->northstar = $northstar;
        $this->repository = $repository;
    }

    /**
     * Create a user in Gladiator.
     *
     * @param  array $credentials
     * @return \Gladiator\Models\User
     */
    public function createUser($account)
    {
        $user = new User;
        $user->id = $account->id;
        $user->role = isset($account->role) ? $account->role : null;
        $user->save();

        $user->first_name = $account->first_name;
        $user->last_name = $account->last_name;
        $user->email = $account->email;

        $this->repository->store($user->id, $user);

        return $user;
    }

    /**
     * Check is user has an account in Northstar.
     *
     * @param  string  $type
     * @param  string  $id
     * @return object|null
     */
    public function findNorthstarAccount($type, $id)
    {
        return $this->northstar->getUser($type, $id);
    }

    /**
     * Resolve user account within Northstar/Gladiator system.
     *
     * @param  array  $credentials
     * @return \Gladiator\Models\User|string
     * @throws \Gladiator\Services\Northstar\Exceptions\NorthstarUserNotFoundException
     */
    public function findUserAccount($credentials)
    {
        $northstarUser = $this->findNorthstarAccount($credentials['term'], $credentials['id']);

        if (! $northstarUser) {
            throw new NorthstarUserNotFoundException;
        }

        $user = $this->repository->find($northstarUser->id);

        if (! $user) {
            return $northstarUser;
        }

        return $user;
    }
}
