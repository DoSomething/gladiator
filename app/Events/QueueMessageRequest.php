<?php

namespace Gladiator\Events;

use Gladiator\Models\Message;
use Illuminate\Queue\SerializesModels;

class QueueMessageRequest extends Event
{
    use SerializesModels;

    /**
     * Email instance.
     *
     * @var \Gladiator\Utilities\Email
     */
    public $email;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($email)
    {   
        $this->email = $email;
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
