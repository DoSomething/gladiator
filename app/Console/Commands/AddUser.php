<?php

namespace Gladiator\Console\Commands;

use Gladiator\Models\User;
use Illuminate\Console\Command;

class AddUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:user {email} {--r|role=staff : The role to assign to this user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Adds a new authorized user from Northstar';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $email = $this->argument('email');
        $role = $this->option('role');

        if (! matchEmailDomain($email)) {
            return $this->comment(PHP_EOL . $email . ' is invalid. Admin or Staff require a DoSomething.org email.' . PHP_EOL);
        }


        $northstarUser = findNorthstarAccount($email, 'email');

        if (is_null($northstarUser)) {
            return $this->comment(PHP_EOL . 'No user found on Northstar with email: ' . $email . '. Create an account at https://dosomething.org.' . PHP_EOL);
        }

        $gladiatorUser = findGladiatorAccount($northstarUser->id);

        if (is_null($gladiatorUser)) {
            $user = new User;
            $user->id = $northstarUser->id;
            $user->role = $role;
            $user->save();

            return $this->comment(PHP_EOL . $email . ' added as a new "' . $role . '" user with id: ' . $northstarUser->id . PHP_EOL);
        }

        return $this->comment(PHP_EOL . $email . ' already exists as a user in Gladiator with a role of "' . $gladiatorUser->role . '"!' . PHP_EOL);
    }
}
