<?php

use Gladiator\Models\WaitingRoom;
use Illuminate\Database\Seeder;

class WaitingRoomTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(WaitingRoom::class, 3)->create();
    }
}
