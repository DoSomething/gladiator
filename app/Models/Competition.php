<?php

namespace Gladiator\Models;

use DB;
use Illuminate\Database\Eloquent\Model;

class Competition extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['contest_id', 'competition_start_date', 'competition_end_date'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['competition_start_date', 'competition_end_date'];

    /**
     * A Competition belongs to many Users.
     */
    public function users()
    {
        $this->belongsToMany(User::class);
    }
}
