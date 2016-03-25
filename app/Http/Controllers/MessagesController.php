<?php

namespace Gladiator\Http\Controllers;

use Gladiator\Models\Message;
use Gladiator\Events\QueueMessageRequest;

class MessagesController extends Controller
{
    /**
     * Fire an event that queues a message to be sent.
     *
     * @param int $id
     */
    public static function sendMessage($id)
    {
        $msg = Message::find($id);

        event(new QueueMessageRequest($msg));
    }
}
