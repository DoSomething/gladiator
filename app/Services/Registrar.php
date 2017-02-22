<?php

namespace Gladiator\Services;

use Gladiator\Models\User;
use DoSomething\Gateway\Northstar;
// use Gladiator\Services\Northstar\Northstar;
use Gladiator\Repositories\UserRepositoryContract;
use Gladiator\Services\Northstar\Exceptions\NorthstarUserNotFoundException;

class Registrar
{
    /**
     * Northstar instance.
     *
     * @var \Gladiator\Services\Northstar\Northstar
     */
    protected $northstar;

    /**
     * UserRepositoryContract instance.
     *
     * @var \Gladiator\Repositories\UserRepositoryContract
     */
    protected $repository;

    /**
     * Create new Registrar instance.
     *
     * @param Northstar $northstar
     */
    public function __construct(Northstar $northstar, UserRepositoryContract $repository)
    {
        $this->northstar = $northstar;
        $this->repository = $repository;
    }

    /**
     * Create a user in Gladiator.
     *
     * @param  array $account
     * @return object
     */
    public function createUser($account)
    {
        return $this->repository->create($account);
    }

    /**
     * Check if user has an account in Northstar.
     *
     * @param  string  $type
     * @param  string  $id
     * @return object|null
     * @deprecated
     */
    public function findNorthstarAccount($type, $id)
    {
        return $this->northstar->getUser($type, $id);
    }

    /**
     * Resolve user account within Northstar/Gladiator system.
     *
     * @param  array  $credentials
     * @return \Gladiator\Models\User|object
     * @throws \Gladiator\Services\Northstar\Exceptions\NorthstarUserNotFoundException
     */
    public function findUserAccount($credentials)
    {
        $northstarUser = $this->northstar->getUser($credentials['term'], $credentials['id']);

        if (! $northstarUser) {
            throw new NorthstarUserNotFoundException;
        }

        // @TODO: Can't use Repository method below because it throws exception
        // and here we just need "null" if user not found in Database. Find a
        // better fix if necessary!
        $user = User::find($northstarUser->id);

        if (! $user) {
            return $northstarUser;
        }

        return $user;
    }
}
