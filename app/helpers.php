<?php

use Gladiator\Models\User;
use Gladiator\Services\Northstar\Exceptions\NorthstarUserNotFoundException;

if (! function_exists('matchEmailDomain')) {
    /**
     * Match supplied email against a specific domain or default domain.
     *
     * @param  string  $email
     * @param  string  $domain
     * @return boolean
     */
    function matchEmailDomain($email, $domain = 'dosomething.org')
    {
        $pieces = explode('@', $email);

        if (is_array($pieces) && count($pieces) > 1) {
            return $pieces[1] === $domain ? true : false;
        }

        return false;
    }
}

if (! function_exists('findUserInSystem')) {
    /**
     * @param  string  $id
     * @param  string  $email
     * @return \Gladiator\Models\User|string
     * @throws \Gladiator\Services\Northstar\Exceptions\NorthstarUserNotFoundException
     */
    function findUserInSystem($id, $type = 'email')
    {
        $northstarUser = findNorthstarAccount($id, $type);

        if (! $northstarUser) {
            throw new NorthstarUserNotFoundException;
        }

        $gladiatorUser = findGladiatorAccount($northstarUser->id);

        if (! $gladiatorUser) {
            return $northstarUser->id;
        }

        return $gladiatorUser;
    }
}

if (! function_exists('findGladiatorAccount')) {
    /**
     * @param  string  $id
     * @return \Gladiator\Models\User|null
     */
    function findGladiatorAccount($id)
    {
        return User::find($id);
    }
}

if (! function_exists('findNorthstarAccount')) {
    /**
     * @param  string  $id
     * @param  string  $type
     * @return object|null
     */
    function findNorthstarAccount($id, $type = 'email')
    {
        $northstar = app('northstar');

        return $northstar->getUser($id, $type);
    }
}
