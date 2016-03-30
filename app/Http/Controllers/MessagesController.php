<?php

namespace Gladiator\Http\Controllers;

use Gladiator\Models\Message;
use Gladiator\Events\QueueMessageRequest;

class MessagesController extends Controller
{


    /**
     * Display the specified resource.
     *
     * @param  string  $id  Contest ID
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $messages = Message::where('contest_id', '=', $id)->get();

        return view('messages.show', compact('messages'));
    }
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
