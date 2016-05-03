<?php

namespace Gladiator\Listeners;

use Illuminate\Mail\Mailer;
use Gladiator\Events\QueueMessageRequest;
use Illuminate\Contracts\Queue\ShouldQueue;
use Gladiator\Models\Message;
use Gladiator\Services\Email;

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
        $resources = $event->resources;

        // Build the email.
        $email = new Email($resources);

        if (isset($email->allMessages)) {
            foreach ($email->allMessages as $content) {
                $settings = [
                    'subject' => $content['message']['subject'],
                    'from' => $email->contest->sender_email,
                    'from_name' => $email->contest->sender_name,
                    'to' => $content['user']->email,
                    'to_name' => $content['user']->first_name,
                ];

                $this->sendMail($content['message'], $settings);
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
        $this->mail->queue('messages.' . $content['type'], ['content' => $content], function ($msg) use ($settings) {
            $msg->from($settings['from'], $settings['from_name']);

            $msg->to($settings['to'], $settings['to_name'])->subject($settings['subject']);
        });
    }
}
