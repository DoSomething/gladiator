<?php

namespace Gladiator\Http\Utilities;

use Gladiator\Models\Contest;
use Gladiator\Models\Competition;
use Gladiator\Models\Message;

class Email
{
    // @TODO - docblock
    protected $message;

    // @TODO - docblock
    protected $competition;

    // @TODO - docblock
    protected $users;

    // @TODO - docblock
    public $contest;

    // @TODO - docblock
    public $allMessages;

    public function __construct(Message $message, Contest $contest, Competition $competition, $users)
    {
        $this->message = $message;
        $this->contest = $contest;
        $this->competition = $competition;
        $this->users = $users;

        $this->setupEmail();
    }

    // @TODO - docblock
    protected function defineTokens($user)
    {
        // @TODO - should we set defaults if things don't resolve?
        $tokens = [
            ':competition_end_date' => $this->competition->competition_end_date,
            ':leaderboard_msg_day' => $this->competition->leaderboard_msg_day,
            ':first_name' => $user->first_name,
        ];

        return $tokens;
    }

    // @TODO - docblock
    protected function replaceMessage($tokens, $message) {
        $preparedMessage = clone $message;

        // // @TODO - maybe loop through message properties and run the replace on each one.
        $preparedMessage->body = $this->replaceTokens($tokens, $message->body);
        $preparedMessage->subject = $this->replaceTokens($tokens, $message->subject);

        return $preparedMessage;
    }

    // @TODO - docblock
    protected function replaceTokens($tokens, $string)
    {
        return str_replace(array_keys($tokens), array_values($tokens), $string);
    }

    // @TODO - docblock
    protected function setupEmail()
    {
        foreach ($this->users as $key => $user) {
            $this->allMessages[$key]['user'] = $user;

            $tokens = $this->defineTokens($user);
            $this->allMessages[$key]['message'] = $this->replaceMessage($tokens, $this->message);
        }
    }

}
