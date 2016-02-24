<?php

namespace Gladiator\Models;

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
     * A User belongs to many Competitions
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
}
