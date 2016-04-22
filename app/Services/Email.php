<?php

namespace Gladiator\Services;

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
    public function __construct($resources)
    {
        $this->message = $resources['message'];
        $this->contest = $resources['contest'];
        $this->competition = $resources['competition'];
        $this->users = $resources['users'];

        $this->manager = app(\Gladiator\Services\Manager::class);

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
            ':prove_it_link:'         => url(config('services.phoenix.uri') .'/node/' . $this->contest->campaign_id . '#prove'),
            ':reportback_noun:'       => strtolower($this->contest->campaign->reportback_info->noun),
            ':reportback_verb:'       => strtolower($this->contest->campaign->reportback_info->verb),
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
        $parsableProperties = ['subject', 'body', 'signoff', 'pro_tip'];

        $processedMessage['type'] = $message->type;

        foreach ($parsableProperties as $prop) {
            $processedMessage[$prop] = $this->replaceTokens($tokens, $message->$prop);
            $processedMessage[$prop] = $this->parseLinks($processedMessage[$prop]);
            $processedMessage[$prop] = nl2br($processedMessage[$prop]);
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
     * Builds the email array.
     */
    protected function setupEmail()
    {
        // Each user gets it's own processed message
        foreach ($this->users as $key => $user) {
            $this->allMessages[$key]['user'] = $user;

            $tokens = $this->defineTokens($user);

            $this->allMessages[$key]['message'] = $this->processMessage($tokens, $this->message);

            if ($this->message->type == 'leaderboard') {
                $this->allMessages[$key]['message'] = array_merge($this->allMessages[$key]['message'], $this->processLeaderboardVars($this->users));
            }
        }
    }

    /*
     * Sets the variables needed for leaderboard emails
     * including the full leaderboard and the top three reportbacks.
     *
     * @param  array $users
     */
    protected function processLeaderboardVars($users)
    {
        $list = $this->manager->catalogUsers($users);
        $leaderboard = $list['active'];

        $vars = [
            'leaderboard' => $leaderboard,
            'topThree' => $this->manager->getTopThreeReportbacks($leaderboard),
        ];

        return $vars;
    }
}
