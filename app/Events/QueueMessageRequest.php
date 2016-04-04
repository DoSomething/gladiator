<?php

namespace Gladiator\Events;

use Gladiator\Models\Message;
use Illuminate\Queue\SerializesModels;

class QueueMessageRequest extends Event
{
    use SerializesModels;

    /**
     * Message instance.
     *
     * @var \Gladiator\Utilities\Email
     */
    public $email;
    public $user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($email, $user)
    {
        $this->email = $email;
        $this->user = $user;
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
