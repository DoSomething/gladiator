<?php

namespace Gladiator\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class WaitingRoom extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['contest_id', 'signup_start_date', 'signup_end_date'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['signup_start_date', 'signup_end_date'];

    /**
     * A WaitingRoom belongs to many Users.
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function getCSVExport() {
        $csv = \League\Csv\Writer::createFromFileObject(new \SplTempFileObject());

        $csv->insertOne(['id']);
        $users = $this->users;
        foreach ($users as $user) {
            $csv->insertOne($user->id);
        }

        return $csv;
    }

    /*
     * Equally splits the users of a waiting room into arrays
     * representing competitions.
     */
    public function getDefaultSplit()
    {
        $users = $this->users;

        // Get the size of the waiting room
        $roomSize = count($users);

        // Determine the amount of competitions to make
        $numOfCompetitions = $roomSize / 300;

        // Create the competitions
        $competitions = [];
        for ($index = 0; $index < $numOfCompetitions; $index++) {
            array_push($competitions, []);
        }

        // Split the users into them
        $index = 0;
        foreach ($users as $user) {
            array_push($competitions[$index], $user->id);

            // Reset the index once you go past the total number of groups
            $index++;
            if ($index >= $numOfCompetitions) {
                $index = 0;
            }
        }

        return $competitions;
    }

    /*
     * Creates competitions based on the given user split.
     */
    public function saveSplit($contest, $split)
    {
        $startDate = Carbon::now()->startOfDay();
        $endDate = Carbon::now()->addDays($contest->duration)->endOfDay();

        foreach ($split as $competitionGroup) {
            // For each split, create a competition.
            $competition = new Competition;

            $competition->contest_id = $contest->getKey();
            $competition->competition_start_date = $startDate;
            $competition->competition_end_date = $endDate;

            $contest->competitions()->save($competition);

            // For each user in this group
            foreach ($competitionGroup as $userId) {
                $user = User::find($userId);

                // Remove them from the waiting room pivot table
                $user->waitingRooms()->detach();

                // Add them to the competitions pivot table
                $user->competitions()->attach($competition->id);
            }
        }
    }
}
