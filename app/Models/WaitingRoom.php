<?php

namespace Gladiator\Models;

use Illuminate\Database\Eloquent\Model;

class WaitingRoom extends Model
{
    protected $fillable = ['campaign_id', 'campaign_run_id', 'signup_start_date', 'signup_end_date'];

    /**
     * A WaitingRoom belongs to many Users.
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
