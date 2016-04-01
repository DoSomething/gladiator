<?php

namespace Gladiator\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ['contest_id', 'type', 'key', 'label', 'subject', 'body'];

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
     * Get the list of Message types.
     *
     * @return array
     */
    public static function getTypes()
    {
        return static::$types;
    }

    public static function prepareMessage($message, $model)
    {
        //@TODO: I only tested this with competition, is there other things we want to replace?
        $tokens = $model::$tokenizable;
        foreach ($tokens as $token) {
            $message->body = str_replace(':'.$token, $model->$token, $message->body);
            //@TODO: handle the message subject.
        }

        return $message;
    }
}
