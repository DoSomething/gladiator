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
        $user = $event->user;

        $type = $email->message->type;
            // dd($email->competition->users);
        $this->mail->send('messages.' . $type, ['email' => $email, 'user' => $user], function ($msg) use ($email, $user) {
            $content = Email::prepareMessage($email->message, $email->competition);
            $subject = Email::prepareSubject($email->message, $user);

            // $content = Email::prepareMessage($email->message, $email->competition);

            // Pulled from the contest.
            $msg->from($email->contest->sender_email, $email->contest->sender_name);

            // @TODO - send to users in competition that triggered the send.
            // can be an array of email addresses.
            // this is just sending as a test to the person who made the contest.
            $msg->to($email->contest->sender_email, $email->contest->sender_name)->subject($email->message->subject);
        });
    }
}
