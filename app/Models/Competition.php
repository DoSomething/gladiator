<?php

namespace Gladiator\Models;

use Gladiator\Models\User;
use Illuminate\Database\Eloquent\Model;

class Competition extends Model
{
    /**
     * A Competition belongs to many Users.
     */
    public function users()
    {
        $this->belongsToMany(User::class);
    }
}
