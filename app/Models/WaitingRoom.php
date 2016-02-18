<?php

namespace Gladiator\Models;

use Gladiator\Models\User;
use Illuminate\Database\Eloquent\Model;

class WaitingRoom extends Model
{
    public function users()
    {
        $this->belongsToMany(User::class);
    }
}
