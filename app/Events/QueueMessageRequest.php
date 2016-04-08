<?php

namespace Gladiator\Events;

use Illuminate\Queue\SerializesModels;

class QueueMessageRequest extends Event
{
    use SerializesModels;

    /**
     * Array of model instances we need for email sending.
     *
     * @var array
     */
    public $resources;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($resources)
    {
        $this->resources = $resources;
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
