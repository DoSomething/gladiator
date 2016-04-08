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
            ':end_date'              => $this->competition->competition_end_date->format('F d, Y'),
            ':leaderboard_msg_day'   => get_day_of_week($this->competition->leaderboard_msg_day),
            ':leaderboard-1'         => get_day_of_week($this->competition->leaderboard_msg_day - 1),
            ':first_name'            => $user->first_name,
            ':sender_name'           => $this->contest->sender_name,
            ':campaign_title'        => $this->contest->campaign->title,
            ':reportback_noun'       => $this->contest->campaign->reportback_info->noun,
            ':reportback_verb'       => $this->contest->campaign->reportback_info->verb,
            ':pro_tip'               => $this->message->pro_tip,
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
        $preparedMessage = clone $message;

        // // @TODO - maybe loop through message properties and run the replace on each one.
        $preparedMessage->body = $this->replaceTokens($tokens, $message->body);
        $preparedMessage->subject = $this->replaceTokens($tokens, $message->subject);

        return $preparedMessage;
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
