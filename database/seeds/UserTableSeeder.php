<?php

use Gladiator\Models\User;
use Gladiator\Models\WaitingRoom;
use Illuminate\Database\Seeder;
use Gladiator\Services\Northstar\Northstar;

class UserTableSeeder extends Seeder
{
    /**
     * Northstar instance.
     *
     * @var \Gladiator\Services\Northstar\Northstar
     */
    protected $northstar;

    /**
     * Create new Registrar instance.
     *
     * @param Northstar $northstar
     */
    public function __construct(Northstar $northstar)
    {
        $this->northstar = $northstar;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Add Contestant Users
        $waitingRooms = WaitingRoom::all();
        $totalRooms = count($waitingRooms);
        $seedContestants = $this->northstar->getAllUsers(['limit' => 100]);

        foreach ($seedContestants as $contestant) {
            $index = mt_rand(0, ($totalRooms - 1));

            // Using first or create if someone is already an admin.
            $user = User::firstOrCreate([
                 'id' => $contestant->id,
                ]);

            $user->waitingRooms()->save($waitingRooms[$index]);
        }
    }
}
