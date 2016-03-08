<?php

use Carbon\Carbon;
use Gladiator\Models\Contest;
use Gladiator\Models\Competition;
use Illuminate\Database\Seeder;

class CompetitionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get the first contest created.
        $contest = Contest::find(1);

        // Create three random competions for it.
        $numCompetitions = 3;

        for ($i = 0; $i < $numCompetitions; $i++) {
            $competition = new Competition;

            $competition->contest_id = $contest->getKey();
            $competition->competition_start_date = Carbon::now()->addWeeks(1)->startOfDay();
            $competition->competition_end_date = Carbon::now()->addWeeks(3)->endOfDay();

            $contest->competitions()->save($competition);
        }
    }
}
