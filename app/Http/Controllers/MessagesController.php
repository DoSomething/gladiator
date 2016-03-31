<?php

namespace Gladiator\Http\Controllers;

use Gladiator\Models\Contest;
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
    public static function sendMessage(Message $message)
    {
        $contest_id = request('contest_id');
        $from = Contest::find($contest_id)->sender;

        event(new QueueMessageRequest($message, $from));

        return redirect()->route('messages.show', $contest_id)->with('status', 'Fired that right the hell off!');
    }
}
