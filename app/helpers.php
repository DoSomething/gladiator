<?php

use Gladiator\Models\User;
use Gladiator\Services\Northstar\Exceptions\NorthstarUserNotFoundException;

/**
 * Match supplied email against a specific domain or default domain.
 *
 * @param  string  $email
 * @param  string  $domain
 * @return bool
 */
function matchEmailDomain($email, $domain = 'dosomething.org')
{
    $pieces = explode('@', $email);

    if (is_array($pieces) && count($pieces) > 1) {
        return $pieces[1] === $domain ? true : false;
    }

    return false;
}

/**
 * @param  string  $id
 * @param  string  $email
 * @return \Gladiator\Models\User|string
 * @throws \Gladiator\Services\Northstar\Exceptions\NorthstarUserNotFoundException
 */
function findUserAccountInSystem($id, $type = 'email')
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

/**
 * @param  string  $id
 * @return \Gladiator\Models\User|null
 */
function findGladiatorAccount($id)
{
    return User::find($id);
}

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
