<?php

namespace Gladiator\Models;

use DB;
use Illuminate\Database\Eloquent\Model;

class Competition extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['campaign_id', 'campaign_run_id', 'start_date', 'end_date'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['start_date', 'end_date'];

    /**
     * A Competition belongs to many Users.
     */
    public function users()
    {
        $this->belongsToMany(User::class);
    }

    /**
     * Get all users in a competition.
     *
     * @TODO - right now this just gets all the users in the competitions_user table that have the correct competition id
     * however, I imagine, we would want some sort of "bracket id", so we can list users by their bracket instead of one,
     * all encompassing list.
     *
     * Once the Bracket table is set up, we should have a bracket model, that defines a query scope to get all users within a bracket.
     */
    public static function getBrackets($competition_id)
    {
        return DB::table('competition_user')->where('competition_id', $competition_id)->get();
    }
}
