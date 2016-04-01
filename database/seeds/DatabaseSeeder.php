<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ContestTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(CompetitionTableSeeder::class);
        $this->call(MessageTableSeeder::class);
    }
}
