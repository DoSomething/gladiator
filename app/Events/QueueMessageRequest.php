<?php

namespace Gladiator\Events;

use Gladiator\Events\Event;
use Gladiator\Models\Message;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class QueueMessageRequest extends Event
{
    use SerializesModels;

    public $message;

    /**
     * Create a new event instance.
     *
     * @TODO - this might need also to take in a competition id so we can
     * pull the users in the competition before sending.
     *
     * @return void
     */
    public function __construct(Message $message)
    {
        $this->message = $message;
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
