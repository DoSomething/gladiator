<?php

use Gladiator\Models\User;
use Gladiator\Models\WaitingRoom;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
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
        // Add Admin Users
        $admins = [
            'agaither@dosomething.org',
            'ssmith@dosomething.org',
            'mfantini@dosomething.org',
            'dlorenzo@dosomething.org',
            'jkent@dosomething.org',
            'dfurnes@dosomething.org',
        ];
        foreach ($admins as $admin) {
            Artisan::call('add:user', ['email' => $admin, '--role' => 'admin']);
        }

        // Add Contestant Users
        $waitingRooms = WaitingRoom::all();
        $totalRooms = count($waitingRooms);
        $seedContestants = $this->northstar->getSeedUsers(300);

        foreach ($seedContestants as $contestant) {
            $index = mt_rand(0, ($totalRooms - 1));

            // Using first or create if someone is already an admin.
            $user = User::firstOrCreate([
                 'id' => $contestant->id
                ]);

            $user->waitingRooms()->save($waitingRooms[$index]);
        }
    }
}
