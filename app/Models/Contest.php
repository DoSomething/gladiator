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
    protected $fillable = ['campaign_id', 'campaign_run_id', 'duration'];

    /**
     * Get the waiting room associated with this contest.
     */
    public function waitingRoom()
    {
        return $this->hasOne(WaitingRoom::class);
    }

    /**
     * Get the competition associated with this contest.
     */
    public function competitions()
    {
        return $this->hasMany(competition::class);
    }

    /**
     * Gets a CSV export of all the users in this waiting room.
     *
     * @return \League\Csv\ $csv
     */
    public function getCSVExport()
    {
        $csv = \League\Csv\Writer::createFromFileObject(new \SplTempFileObject());

        $csv->insertOne(['competition id']);

        $competitions = $this->competitions;
        foreach ($competitions as $competition) {
            $csv->insertOne($competition->id);
        }

        return $csv;
    }
}
