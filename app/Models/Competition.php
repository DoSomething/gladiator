<?php

namespace Gladiator\Models;

use Illuminate\Database\Eloquent\Model;

class Competition extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['contest_id', 'competition_start_date', 'competition_end_date'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['competition_start_date', 'competition_end_date'];

    /**
     * A Competition belongs to many Users.
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * Gets a CSV export of all the users in this competition.
     *
     * @return \League\Csv\ $csv
     */
    public function getCSVExport()
    {
        $csv = \League\Csv\Writer::createFromFileObject(new \SplTempFileObject());

        $csv->insertOne(['id']);
        $users = $this->users;
        foreach ($users as $user) {
            $csv->insertOne($user->id);
        }

        return $csv;
    }
}
