<?php

use Gladiator\Models\User;
use Gladiator\Models\WaitingRoom;
use Illuminate\Database\Seeder;
use Gladiator\Console\Commands;

class UserTableSeeder extends Seeder
{
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

        for ($i = 0; $i < 300; $i++) {
            $index = mt_rand(0, ($totalRooms - 1));

            $user = factory(User::class)->create();

            $user->waitingRooms()->save($waitingRooms[$index]);
        }
    }
}
