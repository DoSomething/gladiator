<?php

namespace Gladiator\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    /**
     * Array of available message types.
     *
     * @var array
     */
    protected static $types = [
        'leaderboard_final',
        'leaderboard_update',
        'reminder',
        'reminder_first',
        'reminder_last',
        'welcome',
    ];

    /**
     * Get the contest associated with this message.
     */
    public function contest()
    {
        return $this->belongsTo(Contest::class);
    }

    /**
     * Get the list of Message types.
     *
     * @return array
     */
    public static function getTypes()
    {
        return static::$types;
    }
}
