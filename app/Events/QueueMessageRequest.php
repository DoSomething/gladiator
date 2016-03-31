<?php

namespace Gladiator\Events;

use Gladiator\Models\Message;
use Gladiator\Models\Competition;
use Illuminate\Queue\SerializesModels;

class QueueMessageRequest extends Event
{
    use SerializesModels;

    /**
     * Message instance.
     *
     * @var \Gladiator\Models\Message
     */
    public $message;
    public $sender;
    public $competition;

    /**
     * Create a new event instance.
     *
     * @TODO - this might need also to take in a competition id so we can
     * pull the users in the competition before sending.
     *
     * @return void
     */
    public function __construct(Message $message, $sender, Competition $competition)
    {
        $this->message = $message;
        $this->sender = $sender;
        $this->competition = $competition;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
