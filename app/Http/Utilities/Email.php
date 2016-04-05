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

    // @TODO - docblock
    protected $tokens;

    public function __construct(Message $message, Contest $contest, Competition $competition)
    {
        $this->message = $message;
        $this->contest = $contest;
        $this->competition = $competition;

        $userRepository = app(\Gladiator\Repositories\UserRepositoryContract::class);
        $this->user = $userRepository->find('559442cca59dbfc9578b4bf4');

        $this->defineTokens();
        $this->prepareMessage();
    }

    protected function defineTokens()
    {
        // @TODO - should we set defaults if things don't resolve?
        $this->tokens = [
            ':competition_end_date' => $this->competition->competition_end_date,
            ':leaderboard_msg_day' => $this->competition->leaderboard_msg_day,
            ':first_name' => $this->user->first_name,
        ];
    }

    public function prepareMessage() { 
        $this->message->body = $this->replaceTokens($this->tokens, $this->message->body);
        $this->message->subject = $this->replaceTokens($this->tokens, $this->message->subject);

        dd($this->message);

        // dd();
    }

    protected function replaceTokens($tokens, $string)
    {
        return str_replace(array_keys($tokens), array_values($tokens), $string);
    }
}
