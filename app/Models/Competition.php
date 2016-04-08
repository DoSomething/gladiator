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
    protected $fillable = ['contest_id', 'competition_start_date', 'competition_end_date', 'leaderboard_msg_day'];

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
     * Return the leaderboard day of week as an integer
     */
    public function getLeaderboardMsgDayAttribute($value)
    {
        // Return day of the week as an int
        return (int) $value;
    }
}
