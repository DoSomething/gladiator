<?php

namespace Gladiator\Models;

use Illuminate\Database\Eloquent\Model;

class LeaderboardPhotos extends Model
{
    /**
     * Get the fillable attributes for the model.
     *
     * @return array
     */
    protected $fillable = ['reportback_id', 'reportback_item_id'];

    /**
     * A LeaderboardPhotos belongs to one user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * A LeaderboardPhotos belongs to one competition.
     */
    public function competition()
    {
        return $this->belongsTo(Competition::class);
    }

    /**
     * A LeaderboardPhotos belongs to one message.
     */
    public function message()
    {
        return $this->belongsTo(Message::class);
    }
}
