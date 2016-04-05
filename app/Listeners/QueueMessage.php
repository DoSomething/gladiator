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

        foreach ($email->allMessages as $message) {
            $content = $message['message'];
            $user = $message['user'];
            $type = $content->type;

            if ($user->email) {
                $this->mail->queue('messages.' . $type, ['body' => $content->body], function ($msg) use ($email, $content, $user) {
                    // Pulled from the contest.
                    $msg->from($email->contest->sender_email, $email->contest->sender_name);

                    // Send to user. 
                    // CAREFUL! Make sure you are using dev sendings or you could actually send an email. 
                    $msg->to($user->email, $user->first_name)->subject($content->subject);
                });
            }
        }
    }
}
