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
    protected $fillable = ['contest_id', 'competition_start_date', 'competition_end_date', 'leaderboard_msg_day', 'reportback_id', 'reportback_item_id', 'shoutout'];

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
        return $this->belongsToMany(User::class, 'competition_user', 'competition_id', 'northstar_id');
    }

    /**
     * A Competition has many Subscribers.
     */
    public function subscribers()
    {
        return $this->belongsToMany(User::class, 'competition_user', 'competition_id', 'northstar_id')->wherePivot('unsubscribed', '=', 0);
    }

    /**
     * Unsubscribe user from Competition.
     */
    public function unsubscribe($northstar_id)
    {
        return DB::table('competitions_users')->where([
            ['northstar_id', '=', $northstar_id],
            ['competition', '=', $this->id],
        ])->update(['unsubscribed' => 1]);
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
        return (int) $value;
    }
}
