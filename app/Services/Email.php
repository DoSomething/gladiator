<?php

namespace Gladiator\Services;

use Log;
use Gladiator\Models\Contest;
use Gladiator\Models\Message;
use Gladiator\Models\Competition;
use Gladiator\Models\FeaturedReportback;

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

        $this->competition = isset($resources['competition']) ? $resources['competition'] : null;

        // If a contest is passed in the resources used that, otherwise grab it from the competition.
        $this->contest = isset($resources['contest']) ? $resources['contest'] : $this->competition->contest;

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
            ':end_date:'              => ! is_null($this->competition) ? $this->competition->competition_end_date->format('F d, Y') : '',
            ':first_name:'            => ucwords($user->first_name),
            ':leaderboard_msg_day:'   => ! is_null($this->competition) ? get_day_of_week($this->competition->leaderboard_msg_day) : '',
            ':leaderboard_msg_day-1:' => ! is_null($this->competition) ? get_day_of_week($this->competition->leaderboard_msg_day - 1) : '',
            ':pro_tip:'               => $this->message->pro_tip,
            ':prove_it_link:'         => url(config('services.phoenix.uri') .'/node/' . $this->contest->campaign_id . '#prove'),
            ':reportback_noun:'       => strtolower($this->contest->campaign->reportback_info['noun']),
            ':reportback_verb:'       => strtolower($this->contest->campaign->reportback_info['verb']),
            ':sender_name:'           => $this->contest->sender_name,
            ':rules_url:'             => ! is_null($this->competition) ? $this->competition->rules_url : '',
            ':share_link:'            => url(config('services.phoenix.uri') .'/us/node/' . $this->contest->campaign_id . '?source=user/' . $user->id),
            ':unsubscribe_link:'      => url((config('services.northstar.profile_url') . '/unsubscribe?' . http_build_query(['northstar_id' => $user->id, 'competition_id' => $this->competition->id]))),
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
        $parsableProperties = ['subject', 'body', 'signoff', 'pro_tip', 'shoutout'];
        $processedMessage['type'] = $message->type;
        $processedMessage['key'] = $message->key;
        $processedMessage['show_images'] = $message->show_images;

        foreach ($parsableProperties as $prop) {
            $processedMessage[$prop] = $this->replaceTokens($tokens, $message->$prop);
            $processedMessage[$prop] = $this->parseImageTags($processedMessage[$prop]);
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
     * Handles regex replacement that supports a markdown syntax for image tags.
     *
     * @param  string $string
     */
    protected function parseImageTags($string)
    {
        return preg_replace('/!\[([^\[]+)\]\(([^\)]+)\)/', '<img src=\'\2\' alt=\'\1\'>', $string);
    }

    /**
     * Check that the email is valid.
     *
     * @param  string $email
     */
    protected function validEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    /**
     * Builds the email array.
     */
    protected function setupEmail()
    {
        if ($this->message->type === 'leaderboard') {
            $leaderboardVars = $this->getLeaderboardVars($this->users);
        }

        // Each user gets it's own processed message
        foreach ($this->users as $key => $user) {
            if ($user->email && $this->validEmail($user->email)) {
                $this->allMessages[$key]['user'] = $user;

                $tokens = $this->defineTokens($user);

                $processedMessage = $this->processMessage($tokens, $this->message);

                $message = isset($leaderboardVars) ? array_merge($processedMessage, $leaderboardVars) : $processedMessage;

                $this->allMessages[$key]['message'] = $message;
            } else {
                Log::alert('User email is not valid', ['id' => $user->id, 'email' => $user->email]);
            }
        }
    }

    /*
     * Sets the variables needed for leaderboard emails
     * including the full leaderboard and the top three reportbacks.
     *
     * @param   array $users
     * @return  array $vars
     */
    protected function getLeaderboardVars($users)
    {
        $leaderboard = $this->competition->activity['active'];

        // @TEMP - Convert the NorthstarUser objects that make up the leaderboard array into smaller arrays with just the information we need to display in the email. This is a hacky way of getting around an issue where we can't pass serialized objects to the message view through the mail queue.
        $entryArray = [];

        foreach ($leaderboard as $user) {
            $entry = [];

            $entry = [
                'first_name' => $user->first_name,
                'last_initial' => $user->last_initial,
                'rank' => $user->rank,
                'quantity' => $user->reportback['quantity'],
            ];

            $entryArray[] = $entry;
        }

        $vars = [];

        if ($leaderboard) {
            $vars = [
                'leaderboard' => $entryArray,
                'topThree' => $this->manager->getTopThreeReportbacks($leaderboard, ['competition_id' => $this->competition->id, 'message_id' => $this->message->id]),
                'reportbackInfo' => $this->contest->campaign->reportback_info,
                'featuredReportback' => $this->getFeaturedReportback(),
            ];
        }

        return $vars;
    }

    /*
     * Gets the featured reportback and grabs the properties that
     * email template needs for display.
     *
     * @return  array $featuredReportback
     */
    protected function getFeaturedReportback()
    {
        if (! isset($this->competition)) {
            return;
        }

        $featuredReportback = FeaturedReportback::where('competition_id', '=', $this->competition->id)->where('message_id', '=', $this->message->id)->first();
        if (isset($featuredReportback) && isset($featuredReportback->reportback_id) && isset($featuredReportback->reportback_item_id)) {
            $reportback = $this->manager->appendReportbackItemToMessage($featuredReportback->reportback_id, $featuredReportback->reportback_item_id);

            if ($reportback) {
                return $featuredReportback = [
                    'shoutout' => $featuredReportback->shoutout,
                    'image_url' => $reportback->media->uri,
                    'caption' => $reportback->caption,
                ];
            }
        }

        return null;
    }
}
