<?php

namespace Gladiator\Repositories;

use Gladiator\Models\Message;

class MessageRepository
{
    /**
     * Create a new message.
     *
     * @param  \Gladiator\Models\Contest $contest
     * @param  array $data
     * @return \Gladiator\Models\Message
     */
    public function create($contest, $data)
    {
        $message = new Message($data);

        return $contest->messages()->save($message);
    }

    /**
     * Create a series of messages for a contest based on an
     * associative array of messages keyed on message type.
     *
     * @param  \Gladiator\Models\Contest $contest
     * @param  array $messages
     * @return void
     */
    public function createMessagesForContest($contest, $messages)
    {
        foreach ($messages as $type => $items) {
            foreach ($items as $key => $data) {
                $data['type'] = $type;
                $data['key'] = $key;

                $this->create($contest, $data);
            }
        }
    }
}
