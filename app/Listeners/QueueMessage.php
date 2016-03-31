<?php

namespace Gladiator\Listeners;

use Illuminate\Mail\Mailer;
use Gladiator\Events\QueueMessageRequest;
use Illuminate\Contracts\Queue\ShouldQueue;
use Gladiator\Models\Message;

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
        $content = Message::prepareMessage($event->message, $event->competition);

        $sender = $event->sender;
        $type = $content->type;

        $this->mail->send('messages.' . $type, ['content' => $content, 'sender' => $sender], function ($msg) use ($content, $sender) {

            // @TODO - Pull from name from contest setting.
            $msg->from($sender, 'Beyonce');

            // @TODO - send to users in competition that triggered the send.
            // can be an array of email addresses.
            // this is just sending as a test to the person who made the contest.
            $msg->to($sender, 'shae')->subject($content->subject);
        });
    }
}
