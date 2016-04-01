<?php

namespace Gladiator\Listeners;

use Illuminate\Mail\Mailer;
use Gladiator\Events\QueueMessageRequest;
use Illuminate\Contracts\Queue\ShouldQueue;
use Gladiator\Models\Message;
use Gladiator\Http\Utilities\Email;

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
        $email = $event->email;
        $type = $email->message->type;

        $this->mail->send('messages.' . $type, ['email' => $email], function ($msg) use ($email) {
            $content = Email::prepareMessage($email->message, $email->competition);

            // @TODO - Pull from name from contest setting.
            $msg->from($email->sender, 'Beyonce');

            // @TODO - send to users in competition that triggered the send.
            // can be an array of email addresses.
            // this is just sending as a test to the person who made the contest.
            $msg->to($email->sender, 'shae')->subject($email->message->subject);
        });
    }
}
