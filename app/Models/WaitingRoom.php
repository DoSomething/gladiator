<?php

namespace Gladiator\Models;

use Illuminate\Database\Eloquent\Model;

class WaitingRoom extends Model
{
    protected $fillable = ['campaign_id', 'campaign_run_id', 'signup_start_date', 'signup_end_date'];

    /**
     * A WaitingRoom belongs to many Users.
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
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
    public function saveSplit($competitionInput, $split)
    {
        foreach ($split as $competitionGroup) {
            // For each split, create a competition.
            $competition = Competition::create($competitionInput);

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
