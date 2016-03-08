<?php

namespace Gladiator\Models;

use Illuminate\Database\Eloquent\Model;

class Contest extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['campaign_id', 'campaign_run_id', 'duration'];

    /**
     * Get the waiting room associated with this contest.
     */
    public function waitingRoom()
    {
        return $this->hasOne(WaitingRoom::class);
    }

    /**
     * Get the competition associated with this contest.
     */
    public function competitions()
    {
        return $this->hasMany(competition::class);
    }
}
