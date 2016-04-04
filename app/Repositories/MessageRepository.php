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
        $message->pro_tip = empty($data['pro_tip']) ? null : $data['pro_tip'];

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

    /**
     * Update a message.
     *
     * @param  \Gladiator\Models\Contest  $contest
     * @param  array $data
     * @return \Gladiator\Models\Message
     */
    public function update($contest, $data)
    {
        $message = Message::where('contest_id', '=', $contest->id)->where('type', '=', $data['type'])->where('key', '=', $data['key'])->firstOrFail();
        $message->subject = $data['subject'];
        $message->body = $data['body'];
        $message->pro_tip = empty($data['pro_tip']) ? null : $data['pro_tip'];

        return $message->save();
    }

    /**
     * Update a series of messages for a contest based on an
     * associative array of messages keyed on message type.
     *
     * @param  \Gladiator\Models\Contest $contest
     * @param  array $messages
     * @return void
     */
    public function updateMessagesForContest($contest, $messages)
    {
        foreach ($messages as $type => $items) {
            foreach ($items as $key => $data) {
                $data['type'] = $type;
                $data['key'] = $key;

                $this->update($contest, $data);
            }
        }
    }
}
