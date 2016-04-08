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

        // If on testing environment, send of the first message to the person who create the contest.
        // @TODO - Create real test email functionality in the app.
        if (env('APP_DEBUG')) {
            $content = $email->allMessages[0]['message'];

            $settings = [
                'subject' => $content->subject,
                'from' => $email->contest->sender_email,
                'from_name' => $email->contest->sender_name,
                'to' => $email->contest->sender_email,
                'to_name' =>  $email->contest->sender_name,
            ];

            $this->sendMail($content, $settings);
        } else {
            foreach ($email->allMessages as $message) {
                $content = $message['message'];

                $settings = [
                    'subject' => $content->subject,
                    'from' => $email->contest->sender_email,
                    'from_name' => $email->contest->sender_name,
                    'to' => $message['user']->email,
                    'to_name' => $message['user']->first_name,
                ];

                $this->sendMail($content, $settings);
            }
        }
    }

    /*
     * Queues a message for sending using custom settings.
     *
     * @param  \Gladiator\Models\Message  $content
     * @param  array $settings
     */
    public function sendMail($content, $settings)
    {
        $this->mail->queue('messages.' . $content->type, ['body' => $content->body], function ($msg) use ($settings) {
            $msg->from($settings['from'], $settings['from_name']);

            $msg->to($settings['to'], $settings['to_name'])->subject($settings['subject']);
        });
    }
}
