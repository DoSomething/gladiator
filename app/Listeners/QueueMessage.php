<?php

namespace Gladiator\Listeners;

use Mail;
use Gladiator\Events\QueueMessageRequest;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class QueueMessage
{
    public $mail;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Mail $mail)
    {
        $this->mail = $mail;
    }

    /**
     * Handle the event.
     *
     * @param  QueueMessageRequest  $event
     * @return void
     */
    public function handle(QueueMessageRequest $event)
    {
        $content = $event->message;

        $type = $content->type;

        Mail::send('messages.' . $type, ['content' => $content], function ($msg) use ($content) {

            $msg->from('beyonce@app.com', 'Beyonce');

            $msg->to('ssmith@dosomething.org', 'shae')->subject($content->subject);
        });
    }
}
