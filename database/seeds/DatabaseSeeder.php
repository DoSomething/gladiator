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
        $this->call(MessageSettingTableSeeder::class);
        $this->call(MessageTableSeeder::class);

        // @TODO: We shouldn't be seeding the Competitions for a Contest without afterwards
        // handling and removing the users in that respective Contest's WaitingRoom. It
        // is leading to very confusing data with how the system is intended to work.
        // Commenting out the seeder for now, until we get a chance to refactor it if needed.
        // $this->call(CompetitionTableSeeder::class);
    }
}
