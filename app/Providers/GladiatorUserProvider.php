<?php

namespace Gladiator\Providers;

use Illuminate\Auth\EloquentUserProvider;
use Gladiator\Services\Northstar\Northstar;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Auth\Authenticatable;

class GladiatorUserProvider extends EloquentUserProvider implements UserProvider
{
    /**
     * Retrieve a user by the given credentials.
     *
     * @param  array  $credentials
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByCredentials(array $credentials)
    {
        $northstar = app(Northstar::class);

        $user = $northstar->getUser('email', $credentials['email']);

        if (! $user) {
            return;
        }

        // If a matching Northstar user is found, try to find corresponding Gladiator user.
        return $this->createModel()->where('northstar_id', $user->id)->first();
    }

    /**
     * Validate a user against the given credentials.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  array  $credentials
     * @return bool
     */
    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        $northstar = app(Northstar::class);

        return $northstar->verifyUser($credentials);
    }
}
