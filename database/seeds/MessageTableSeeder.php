<?php

use Gladiator\Models\Contest;
use Gladiator\Models\Message;
use Gladiator\Repositories\MessageRepository;
use Illuminate\Database\Seeder;

class MessageTableSeeder extends Seeder
{
    protected $repository;

    /**
     * Attributes to exclude when seeding default messages.
     *
     * @var array
     */
    protected $excludedAttributes = ['contest_id', 'type', 'key'];

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
        $defaults = correspondence()->defaults();
        $messages = [];

        $contests = Contest::all();

        $model = new Message;
        $types = $model->getTypes();
        $attributes = $model->getFillable();
        $attributes = array_diff($attributes, $this->excludedAttributes);

        foreach ($types as $type) {
            $messages[$type] = [];
        }

        foreach ($defaults as $data) {
            $fields = [];

            foreach ($attributes as $attribute) {
                $fields[$attribute] = $data[$attribute];
            }

            $messages[$data['type']][] = $fields;
        }

        foreach ($contests as $contest) {
            if (! $contest->messages->count()) {
                $this->repository->createMessagesForContest($contest, $messages);
            }
        }
    }
}
