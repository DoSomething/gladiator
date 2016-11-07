<?php

namespace Gladiator\Models;

use Illuminate\Database\Eloquent\Model;

class LeaderboardPhoto extends Model
{
    /**
     * Get the fillable attributes for the model.
     *
     * @return array
     */
    protected $fillable = ['reportback_id', 'reportback_item_id'];

    /**
     * A LeaderboardPhoto belongs to one user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * A LeaderboardPhoto belongs to one competition.
     */
    public function competition()
    {
        return $this->belongsTo(Competition::class);
    }

    /**
     * A LeaderboardPhoto belongs to one message.
     */
    public function message()
    {
        return $this->belongsTo(Message::class);
    }
}
