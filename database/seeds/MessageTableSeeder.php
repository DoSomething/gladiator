<?php

use Gladiator\Models\Contest;
use Gladiator\Models\Message;
use Gladiator\Repositories\MessageRepository;
use Illuminate\Database\Seeder;

class MessageTableSeeder extends Seeder
{
    protected $repository;

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
        $defaults = correspondence()->defaults();
        $types = Message::getTypes();
        $messages = [];

        foreach ($types as $type) {
            $messages[$type] = [];
        }

        foreach ($defaults as $data) {
            $messages[$data['type']][] = [
                'subject' => $data['subject'],
                'body' => $data['body'],
                'label' => $data['label'],
                'signoff' => $data['signoff'],
            ];
        }

        foreach ($contests as $contest) {
            if (! $contest->messages->count()) {
                $this->repository->createMessagesForContest($contest, $messages);
            }
        }
    }
}
