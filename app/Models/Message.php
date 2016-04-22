<?php

namespace Gladiator\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ['contest_id', 'type', 'key', 'label', 'subject', 'body', 'pro_tip', 'signoff'];

    /**
     * Array of available message types.
     *
     * @var array
     */
    protected static $types = [
        'checkin',
        'leaderboard',
        'reminder',
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
     * Set the pro_tip attribute for the message.
     *
     * @param string  $value
     */
    public function setProTipAttribute($value)
    {
        $this->attributes['pro_tip'] = empty($value) ? null : $value;
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
