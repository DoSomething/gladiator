<?php

namespace Gladiator\Http\Controllers;

// use Mail;
use Event;
use Gladiator\Models\Message;
use Gladiator\Events\QueueMessageRequest;
use Illuminate\Http\Request;
use Gladiator\Http\Requests;

class MessagesController extends Controller
{
    public static function sendMessage()
    {
        $msg = new Message();

        $msg->contest_id = 1;
        $msg->type = 'reminder';
        $msg->subject = 'Drunk in love';
        $msg->body = "Surfbordt";

        event(new QueueMessageRequest($msg));
    }
}
