<?php

namespace Gladiator\Models;

use Illuminate\Database\Eloquent\Model;

class Contest extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['campaign_id', 'campaign_run_id', 'sender_email', 'sender_name'];

    /**
     * Attributes that can be queried when filtering.
     *
     * This array is manually maintained. It does not necessarily mean that
     * any of these are actual indexes on the database... but they should be!
     *
     * @var array
     */
    public static $indexes = ['id', 'campaign_id', 'campaign_run_id'];

    /**
     * Get the waiting room associated with this contest.
     */
    public function waitingRoom()
    {
        return $this->hasOne(WaitingRoom::class);
    }

    /**
     * Get the competitions associated with this contest.
     */
    public function competitions()
    {
        return $this->hasMany(Competition::class);
    }

    /**
     * Get the messages associated with this contest.
     */
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    /**
     * Gets a CSV export of all the users in this waiting room.
     *
     * @return \League\Csv\ $csv
     */
    public function getCSVExport()
    {
        $data = [];
        $competitions = $this->competitions;

        array_push($data, ['competition id']);

        foreach ($competitions as $competition) {
            array_push($data, [$competition->id]);
        }

        return build_csv($data);
    }

    /**
     * Set the sender email attribute for the contest.
     *
     * @param string $value
     */
    public function setSenderEmailAttribute($value)
    {
        $this->attributes['sender_email'] = ! empty($value) ? $value : null;
    }

    /**
     * Set the sender name attribute for the contest.
     *
     * @param string $value
     */
    public function setSenderNameAttribute($value)
    {
        $this->attributes['sender_name'] = ! empty($value) ? $value : null;
    }
}
