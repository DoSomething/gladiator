<?php

namespace Gladiator\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    /**
     * Get the fillable attributes for the model.
     *
     * @return array
     */
    protected $fillable = ['contest_id', 'type', 'key', 'label', 'subject', 'body', 'pro_tip', 'signoff', 'reportback_id', 'reportback_item_id'];

    /**
     * Excluded attributes that are not customizeable.
     *
     * @var array
     */
    protected $excludedAttributes = ['contest_id', 'type', 'key'];

    /**
     * Array of available message types.
     *
     * @var array
     */
    protected static $types = ['checkin', 'leaderboard', 'reminder', 'welcome'];

    /**
     * Get the contest associated with this message.
     */
    public function contest()
    {
        return $this->belongsTo(Contest::class);
    }

    /**
     * Get the list of excluded attributes.
     *
     * @return array
     */
    public function getExcludedAttributes()
    {
        return $this->excludedAttributes;
    }

    /**
     * Set the pro_tip attribute for the message.
     *
     * @param string  $value
     */
    public function setProTipAttribute($value)
    {
        $this->attributes['pro_tip'] = ! empty($value) ? $value : null;
    }

    /**
     * Set the reportback_id attribute for the message.
     *
     * @param string  $value
     */
    public function setReportbackIdAttribute($value)
    {
        $this->attributes['reportback_id'] = ! empty($value) ? $value : null;
    }

    /**
     * Set the reportback_item_id attribute for the message.
     *
     * @param string  $value
     */
    public function setReportbackItemIdAttribute($value)
    {
        $this->attributes['reportback_item_id'] = ! empty($value) ? $value : null;
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
