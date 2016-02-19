<?php

use Faker\Factory;
use Gladiator\Models\User;
use Gladiator\Models\WaitingRoom;
use Illuminate\Database\Seeder;

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
        $faker = Factory::create();

        for ($i = 0; $i < 2; $i++) {
            User::create([
                'id' => str_random(24),
                'role' => 'admin',
            ]);
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
