<?php

use Gladiator\Models\User;
use Gladiator\Models\Competition;
use Illuminate\Database\Seeder;

class CompetitionUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get 10 random users.
        $users = User::orderByRaw('RAND()')->take(10)->get();

        // Seed one competition with users
        $competition = factory(Competition::class)->create();

        foreach ($users as $user) {
            $user->competitions()->save($competition);
        }
    }
}
