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
     * Resolve user within system or create new user.
     *
     * @param  array  $credentials
     * @return \Gladiator\Models\User
     */
    public function findOrCreate($credentials)
    {
        $account = $this->hasAccountInSystem($credentials['type'], $credentials['key']);

        if ($account instanceof User) {
            $user = $account;

            session()->flash('status', 'User already exists!');

            return $user;
        }

        $user = new User;
        $user->id = $account;
        $user->role = isset($credentials['role']) ? $credentials['role'] : null;
        $user->save();

        session()->flash('status', 'User has been created!');

        return $user;
    }

    /**
     * Check if user has account within Northstar/Gladiator system.
     *
     * @param  string  $type
     * @param  string  $id
     * @return \Gladiator\Models\User|string
     * @throws \Gladiator\Services\Northstar\Exceptions\NorthstarUserNotFoundException
     */
    public function hasAccountInSystem($type, $id)
    {
        $northstarUser = $this->hasNorthstarAccount($type, $id);

        if (! $northstarUser) {
            throw new NorthstarUserNotFoundException;
        }

        $user = User::find($northstarUser->id);

        if (! $user) {
            return $northstarUser->id;
        }

        return $user;
    }

    /**
     * Check is user has an account in Northstar.
     *
     * @param  string  $type
     * @param  string  $id
     * @return object|null
     */
    public function hasNorthstarAccount($type, $id)
    {
        return $this->northstar->getUser($type, $id);
    }

}
