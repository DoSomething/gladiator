<?php

namespace Gladiator\Models;

use Gladiator\Models\User;
use Illuminate\Database\Eloquent\Model;

class WaitingRoom extends Model
{
    /**
     * A WaitingRoom belongs to many Users.
     */
    public function users()
    {
        $this->belongsToMany(User::class);
    }
}
