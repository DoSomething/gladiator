<?php

namespace Gladiator\Models;

use Gladiator\Models\User;
use Illuminate\Database\Eloquent\Model;

class Competition extends Model
{

    protected $fillable = ['campaign_id', 'campaign_run_id', 'start_date', 'end_date'];

    /**
     * A Competition belongs to many Users.
     */
    public function users()
    {
        $this->belongsToMany(User::class);
    }
}
