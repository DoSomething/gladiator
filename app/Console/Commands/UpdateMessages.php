<?php

namespace Gladiator\Console\Commands;

use Gladiator\Models\Contest;
use Gladiator\Repositories\MessageRepository;
use Illuminate\Console\Command;

class UpdateMessages extends Command
{
    protected $repository;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:messages {contest?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update correspondence messages for all contests as needed';

    /**
     * Create a new command instance.
     *
     * @param \Gladiator\Repositories\MessageRepository  $repository
     * @return void
     */
    public function __construct(MessageRepository $repository)
    {
        parent::__construct();

        $this->repository = $repository;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $contest = $this->argument('contest');

        $messages = $this->repository->buildMessagesFromDefaults();

        if ($contest) {
            $contest = Contest::findOrFail($contest);

            $this->repository->updateMessagesForContest($contest, $messages);

            return $this->comment(PHP_EOL . 'All set! Messages for Contest ID #' . $contest->id . ' have been updated. If any messages were missing, they were added as well!' . PHP_EOL);
        } else {
            $contests = Contest::all();

            foreach ($contests as $contest) {
                $this->repository->updateMessagesForContest($contest, $messages);
            }

            return $this->comment(PHP_EOL . 'All set! Messages for all Contests have been updated. If any messages for a Contest were missing, they were added as well!' . PHP_EOL);
        }
    }
}
