<?php

namespace Gladiator\Console\Commands;

use Gladiator\Models\Contest;
use Illuminate\Console\Command;

class UpdateMessages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:messages {contest?} {--override : Override all contest messages and refresh with latest defaults }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update correspondence messages for all contests as needed';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $contest = $this->argument('contest');

        if ($contest) {
            $contest = Contest::findOrFail($contest);

            dd($contest);
        }
    }
}
