<?php

namespace Gladiator\Services;

use Gladiator\Models\User;
use Gladiator\Services\Northstar\Northstar;
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
     * Create new Registrar instance.
     *
     * @param Northstar $northstar
     */
    public function __construct(Northstar $northstar)
    {
        $this->northstar = $northstar;
    }

    /**
     * Create a user in Gladiator.
     *
     * @param  array $credentials
     * @return \Gladiator\Models\User
     */
    public function createUser($credentials)
    {
        $user = new User;
        $user->id = $credentials['id'];
        $user->role = isset($credentials['role']) ? $credentials['role'] : null;
        $user->save();

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

        $user = User::find($northstarUser->id);

        if (! $user) {
            return $northstarUser->id;
        }

        return $user;
    }
}
