<?php

namespace Gladiator\Console\Commands;

use Gladiator\Models\User;
use Gladiator\Services\Northstar\Northstar;
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
     * The northstar service.
     *
     * @var Northstar
     */
    protected $northstar;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Northstar $northstar)
    {
        parent::__construct();

        $this->northstar = $northstar;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $email = $this->argument('email');
        $role = $this->option('role');

        $northstarUser = $this->northstar->getUser($email);

        if (is_null($northstarUser)) {
            return $this->comment(PHP_EOL . 'No user found on Northstar with email: ' . $email . '. Create an account at https://dosomething.org.' . PHP_EOL);
        }

        $gladiatorUser = User::find($northstarUser->id);

        if (is_null($gladiatorUser)) {
            User::create([
                'id' => $northstarUser->id,
                'role' => $role,
            ]);

            return $this->comment(PHP_EOL . $email . ' added as a new "' . $role . '" user with id: ' . $northstarUser->id . PHP_EOL);
        }

        return $this->comment(PHP_EOL . $email . ' already exists as a user in Gladiator with a role of "' . $gladiatorUser->role . '"!' . PHP_EOL);
    }
}
