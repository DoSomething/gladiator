<?php

namespace Gladiator\Models;

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
        return $this->belongsToMany(User::class);
    }

    /**
     * A competition belongs to one contest.
     */
    public function contest()
    {
        return $this->belongsTo(Contest::class);
    }

   /**
     * Get the leaderboard day of the week.
     *
     * @param  int  $value
     * @return string
     */
    public function getLeaderboardMsgDayAttribute($value)
    {
        // Return day of the week as a string (Monday-Sunday).
        return jddayofweek($value, 1);
    }
}
