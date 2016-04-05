<?php

namespace Gladiator\Http\Utilities;

use Gladiator\Models\Contest;
use Gladiator\Models\Competition;
use Gladiator\Models\Message;
use Gladiator\Repositories\UserRepositoryContract;

class Email
{
    // @TODO - docblock
    protected $message;

    // @TODO - docblock
    protected $contest;

    // @TODO - docblock
    protected $competition;

    protected $tokens;

    public function __construct(Message $message, Contest $contest, Competition $competition)
    {
        $this->message = $message;
        $this->contest = $contest;
        $this->competition = $competition;

        $this->defineTokens();
        $this->prepareMessage();
    }

    protected function defineTokens()
    {
        $this->tokens = [
            ':competition_end_date' => $this->competition->competition_end_date,
            ':leaderboard_msg_day' => $this->competition->leaderboard_msg_day,
            ':first_name' => 'Shae',
        ];
    }

    public function prepareMessage() { 
        $this->message->body = str_replace(array_keys($this->tokens), array_values($this->tokens), $this->message->body);
    }
}
