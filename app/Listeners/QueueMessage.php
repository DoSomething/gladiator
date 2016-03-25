<?php

namespace Gladiator\Listeners;

use Illuminate\Mail\Mailer;
use Gladiator\Events\QueueMessageRequest;
use Illuminate\Contracts\Queue\ShouldQueue;

class QueueMessage implements ShouldQueue
{
    public $mail;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Mailer $mail)
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

        $this->mail->send('messages.' . $type, ['content' => $content], function ($msg) use ($content) {

            // @TODO - Pull from address from contest setting.
            $msg->from('beyonce@app.com', 'Beyonce');

            // @TODO - send to users in competition that triggered the send.
            // can be an array of email addresses.
            $msg->to('ssmith@dosomething.org', 'shae')->subject($content->subject);
        });
    }
}
