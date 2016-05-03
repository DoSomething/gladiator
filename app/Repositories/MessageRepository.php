<?php

namespace Gladiator\Repositories;

use Gladiator\Models\Message;
use Gladiator\Models\Setting;
use Gladiator\Services\Settings\SettingRepository;

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

    /**
     * Build the series of messages from the Correspondence defaults.
     *
     * @return array
     */
    public function buildMessagesFromDefaults()
    {
        $messages = [];

        $defaults = (new SettingRepository)->getAllByCategory('messages', true);

        // dd($defaults->count());

        $model = new Message;
        $types = $model->getTypes();
        $attributes = array_diff($model->getFillable(), $model->getExcludedAttributes());

        foreach ($types as $type) {
            $messages[$type] = [];
        }

        foreach ($defaults as $data) {
            dd($data);
            $fields = [];

            foreach ($attributes as $attribute) {
                $fields[$attribute] = $data->value[$attribute];
            }

            $messages[$data->value['type']][] = $fields;
        }

        return $messages;
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
