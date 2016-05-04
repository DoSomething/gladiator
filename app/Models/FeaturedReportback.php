<?php

namespace Gladiator\Models;

use Illuminate\Database\Eloquent\Model;

class FeaturedReportback extends Model
{
    /**
     * Get the fillable attributes for the model.
     *
     * @return array
     */
    protected $fillable = ['reportback_id', 'reportback_item_id', 'shoutout'];

    /**
     * A FeaturedReportback belongs to one competition.
     */
    public function competition()
    {
        return $this->belongsTo(Competition::class);
    }

    /**
     * A FeaturedReportback belongs to one message.
     */
    public function message()
    {
        return $this->belongsTo(Message::class);
    }

}
