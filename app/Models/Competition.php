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
     * @param \Gladiator\Repositories\UserRepositoryContract $repository
     * @return \League\Csv\ $csv
     */
    public function getCSVExport($repository)
    {
        $data = [];
        $users = $this->users;

        // TODO: Competition/Reportback activity
        array_push($data, ['northstar_id', 'first_name', 'last_name', 'email', 'cell']);
        foreach ($users as $user) {
            $userInfo = $repository->find($user->id);
            array_push($data, [$user->id, $userInfo->first_name, $userInfo->last_name, $userInfo->email, $userInfo->mobile]);
        }

        return buildCSV($data);
    }
}
