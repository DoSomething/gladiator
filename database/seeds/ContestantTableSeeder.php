<?php

use Illuminate\Database\Seeder;

class ContestantTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Gladiator\Models\Contestant::class, 500)->create();
    }
}
