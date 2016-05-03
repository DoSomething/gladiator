<?php

namespace Gladiator\Repositories;

use Gladiator\Models\Message;
use Gladiator\Models\MessageSetting;

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
     * @param  \Gladiator\Models\Contest  $contest
     * @param  array  $messages
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
     * Create a series of messages for a contest based on defaults
     * retrieved from settings.
     *
     * @param  \Gladiator\Models\Contest  $contest
     * @param  array  $messages
     * @return void
     */
    public function createMessagesForContestFromSettings($contest, $messages)
    {
        foreach ($messages as $message) {
            $this->create($contest, $message);
        }
    }

    /**
     * Build the series of messages from the defaults in settings.
     *
     * @return array
     */
    public function getMessagesFromSettings()
    {
        $filteredMessages = [];

        $messages = MessageSetting::all();
        $messages = $messages->toArray();

        foreach ($messages as $message) {
            unset($message['id']);
            unset($message['created_at']);
            unset($message['updated_at']);

            $message['reportback_id'] = null;
            $message['reportback_item_id'] = null;

            $filteredMessages[] = $message;
        }

        return $filteredMessages;
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
        $message = Message::where('contest_id', '=', $contest->id)->where('type', '=', $data['type'])->where('key', '=', $data['key'])->first();

        if (! $message) {
            return $this->create($contest, $data);
        }

        $attributes = $message->getFillable();

        foreach ($attributes as $attribute) {
            if (isset($data[$attribute])) {
                $message->{$attribute} = $data[$attribute];
            }
        }

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
