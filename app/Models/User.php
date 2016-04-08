<?php

namespace Gladiator\Models;

use Gladiator\Services\Northstar\Exceptions\NorthstarUserNotFoundException;
use Illuminate\Foundation\Auth\User as BaseUser;

class User extends BaseUser
{
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];

    /**
     * Array of available roles.
     *
     * @var array
     */
    protected static $roles = [
        'admin' => 'admin',
        'staff' => 'staff',
        'contestant' => null,
    ];

    /**
     * A User belongs to many Competitions.
     */
    public function competitions()
    {
        return $this->belongsToMany(Competition::class);
    }

    /**
     * A User belongs to many WaitingRooms.
     */
    public function waitingRooms()
    {
        return $this->belongsToMany(WaitingRoom::class);
    }

    /**
     * Check if user has specified role.
     *
     * @param  string|array
     * @return bool
     */
    public function hasRole($roles)
    {
        $roles = is_array($roles) ? $roles : [$roles];

        return in_array($this->role, $roles);
    }

    /**
     * Set the role attribute for the user.
     *
     * @param  string  $value
     * @return string
     */
    public function setRoleAttribute($value)
    {
        $this->attributes['role'] = $value === 'member' ? null : $value;
    }

    /**
     * @param  string  $type
     * @param  string  $id
     * @return \Gladiator\Models\User|string
     * @throws \Gladiator\Services\Northstar\Exceptions\NorthstarUserNotFoundException
     * @deprecated
     */
    public static function hasAccountInSystem($type, $id)
    {
        $northstarUser = static::hasNorthstarAccount($type, $id);

        if (! $northstarUser) {
            throw new NorthstarUserNotFoundException;
        }

        $user = static::find($northstarUser->id);

        if (! $user) {
            return $northstarUser->id;
        }

        return $user;
    }

    /**
     * Get list of available roles.
     *
     * @return array
     */
    public static function getRoles()
    {
        return static::$roles;
    }

    /**
     * @param  string  $type
     * @param  string  $id
     * @return object|null
     * @deprecated
     */
    public static function hasNorthstarAccount($type, $id)
    {
        $northstar = app('northstar');

        return $northstar->getUser($type, $id);
    }
}
