<?php

namespace Gladiator\Models;

use Gladiator\Models\User;
use Illuminate\Database\Eloquent\Model;

class WaitingRoom extends Model
{
    protected $fillable = ['campaign_id', 'campaign_run_id', 'signup_start_date', 'signup_end_date'];

    /**
     * A WaitingRoom belongs to many Users.
     */
    public function users()
    {
        $this->belongsToMany(User::class);
    }
}
