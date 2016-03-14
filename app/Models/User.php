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
     * Set the role for the user.
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

    /**
     * Create an array with only the useful user information we need for use in views, etc.
     */
    public static function setUserInfo($user)
    {
        $info = [
            'id' => $user->user_id,
        ];

        // Get northstar account.
        // @TODO - grab user northstar info from cache.
        $northstarUser = static::hasNorthstarAccount('_id', $user->user_id);

        if ($northstarUser) {
            $lastName = ($northstarUser->last_name) ? $northstarUser->last_name : '';

            $info += [
                'name'  => $northstarUser->first_name . ' ' . $lastName,
                'email' => $northstarUser->email,
                'phone' => $northstarUser->mobile,
                // @TODO - add pertinent signup info.
                'signup' => null,
            ];
        } else {
            $info += [
                'name'  => $user->user_id,
            ];
        }

        return $info;
    }
}
