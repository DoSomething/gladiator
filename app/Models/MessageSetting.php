<?php

namespace Gladiator\Models;

use Illuminate\Database\Eloquent\Model;

class MessageSetting extends Model
{
    /**
     * Get the fillable attributes for the model.
     *
     * @return array
     */
    protected $fillable = ['type', 'key', 'label', 'subject', 'body', 'pro_tip', 'signoff'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'messages_settings';
}
