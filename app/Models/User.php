<?php

namespace Gladiator\Models;

use Gladiator\Models\Competition;
use Gladiator\Models\WaitingRoom;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];

    public function competitions()
    {
        return $this->belongsToMany(Competition::class);
    }

    public function waitingRooms()
    {
        return $this->belongsToMany(WaitingRoom::class);
    }
}
