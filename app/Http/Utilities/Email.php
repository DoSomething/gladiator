<?php

namespace Gladiator\Http\Utilities;

use Gladiator\Models\Contest;
use Gladiator\Models\Competition;
use Gladiator\Models\Message;

class Email
{
    /**
     * Message instance.
     *
     * @var \Gladiator\Models\Message
     */
    protected $message;

    /**
     * Competition instance.
     *
     * @var \Gladiator\Models\Competition
     */
    protected $competition;

    /**
     * Northstar user
     *
     * @var object
     */
    protected $users;

    /**
     * Contest instance.
     *
     * @var \Gladiator\Models\Contest
     */
    public $contest;

    /**
     * Array of all processed messages for per user
     *
     * @var array
     */
    public $allMessages;

    /**
     * Constructor
     */
    public function __construct(Message $message, Contest $contest, Competition $competition, $users)
    {
        $this->message = $message;
        $this->contest = $contest;
        $this->competition = $competition;
        $this->users = $users;

        $this->setupEmail();
    }

    /**
     * Process all of the tokens for this email. New tokens should be defined here.
     * @TODO - possibly move token stuff into it's own class.
     *
     * @param  object $user
     * @return array $tokens
     */
    protected function defineTokens($user)
    {
        // @TODO - set defaults?
        $tokens = [
            ':campaign_title:'        => $this->contest->campaign->title,
            ':end_date:'              => $this->competition->competition_end_date->format('F d, Y'),
            ':first_name:'            => $user->first_name,
            ':leaderboard_msg_day:'   => get_day_of_week($this->competition->leaderboard_msg_day),
            ':leaderboard_msg_day-1:' => get_day_of_week($this->competition->leaderboard_msg_day - 1),
            ':pro_tip:'               => $this->message->pro_tip,
            ':prove_it_link:'         => url(config('services.phoenix.uri') .'/node/' . $this->contest->campaign_id . '#proveit'),
            ':reportback_noun:'       => $this->contest->campaign->reportback_info->noun,
            ':reportback_verb:'       => $this->contest->campaign->reportback_info->verb,
            ':sender_name:'           => $this->contest->sender_name,
        ];

        return $tokens;
    }

    /**
     * Process the message, replacing all tokens with their associated value.
     *
     * @param  array $tokens
     * @param  \Gladiator\Models\Message $message
     * @return \Gladiator\Models\Message $preparedMessage
     */
    protected function processMessage($tokens, $message)
    {
        $parsableProperties = ['subject', 'body', 'pro_tip'];

        $processedMessage = clone $message;

        foreach ($parsableProperties as $prop) {
            $processedMessage->$prop = $this->replaceTokens($tokens, $message->$prop);
            $processedMessage->$prop = $this->parseLinks($processedMessage->$prop);
            $processedMessage->$prop = nl2br($processedMessage->$prop);
        }

        return $processedMessage;
    }

    /**
     * Handles the string replacement
     *
     * @param  array $tokens
     * @param  string $string
     * @return string
     */
    protected function replaceTokens($tokens, $string)
    {
        return str_replace(array_keys($tokens), array_values($tokens), $string);
    }

    /**
     * Handles regex replacement that supports a markdown like link syntax.
     *
     * @param  string $string
     */
    protected function parseLinks($string)
    {
        return preg_replace('/\[([^\[]+)\]\(([^\)]+)\)/', '<a href=\'\2\'>\1</a>', $string);
    }

    /**
     * Builds the email object.
     */
    protected function setupEmail()
    {
        // Each user gets it's own processed message
        foreach ($this->users as $key => $user) {
            $this->allMessages[$key]['user'] = $user;

            $tokens = $this->defineTokens($user);
            $this->allMessages[$key]['message'] = $this->processMessage($tokens, $this->message);
        }
    }
}
