<?php

use Gladiator\Models\Contest;
use Gladiator\Models\Message;
use Gladiator\Repositories\MessageRepository;
use Illuminate\Database\Seeder;

class MessageTableSeeder extends Seeder
{
    /**
     * MessageRepository instance.
     *
     * @var \Gladiator\Repositories\MessageRepository
     */
    protected $repository;

    /**
     * Create a new message table seeder instance.
     *
     * @param \Gladiator\Repositories\MessageRepository  $repository
     */
    public function __construct(MessageRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $contests = Contest::all();

        $messages = $this->repository->buildMessagesFromDefaults();

        foreach ($contests as $contest) {
            if (! $contest->messages->count()) {
                $this->repository->createMessagesForContest($contest, $messages);
            }
        }
    }
}
