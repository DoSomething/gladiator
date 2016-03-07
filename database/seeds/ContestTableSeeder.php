<?php

use Gladiator\Models\Contest;
use Illuminate\Database\Seeder;

class ContestTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Contest::class, 3)->create();
    }
}
