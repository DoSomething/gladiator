<?php

namespace Gladiator\Http\Utilities;

class Correspondence
{
    /**
     * Array of default messages.
     *
     * @var array
     */
    protected static $defaultMessages = [
        [
            'type' => 'welcome',
            'key' => '1',
            'label' => 'Welcome',
            'subject' => 'Welcome, :first_name:!',
            'body' => "Woohoo, so glad you signed up for my :campaign_title: competition, :first_name:! Feel free to get a head start on the competition! Again, winners will be selected based on the greatest number of :reportback_noun: :reportback_verb:.\n\rI’ll be in touch with more info in the next few days. Excited to watch you climb the leaderboard and crush the competition!\n\r:sender_name:",
            'pro_tip' => null,
            'signoff' => null,
        ],
        [
            'type' => 'info',
            'key' => '1',
            'label' => 'Competition info',
            'subject' => ':first_name:! Here’s more :campaign_title: competition info',
            'body' => "Just wanted to send along some more info about the :campaign_title: competition you signed up for! The rules are simple:\n\r1. The more :reportback_noun: :reportback_verb:, the higher you move up the leaderboard.\n\r2. To be considered, go to the [Prove It](:prove_it_link:) section of the campaign and upload a photo that clearly shows you and all :reportback_noun: :reportback_verb:. Submissions are due each :leaderboard_msg_day-1: night throughout the campaign.\n\rThe competitor with the most :reportback_noun: :reportback_verb: by the competition deadline of :end_date:, wins $100 on an Amex gift card. 2nd - $50, 3rd - $25.\n\rYour first update is due on :leaderboard_msg_day-1: before 10 PM EST. If you have an update for me and want to see yourself on :leaderboard_msg_day:’s leaderboard, simply:\n\r   - Go to the [Prove It](:prove_it_link:) section\n\r   - Upload your photo \n\r   - Click “submit your pic”\n\rOn :leaderboard_msg_day:, I will send you the updated standings so you can see yourself on the leaderboard.\n\rRootin’ for ya, :first_name:,\n\r:sender_name:",
            'pro_tip' => null,
            'signoff' => null,
        ],
        [
            'type' => 'checkin',
            'key' => '1',
            'label' => 'Where are you? Check status',
            'subject' => 'Is everything ok, :first_name:?',
            'body' => "I noticed you haven’t upload a picture of your :reportback_noun: :reportback_verb: to :campaign_title: yet. Just wanted to see if everything is ok!\n\rIf you are able, you still have until :leaderboard_msg_day-1: to be included in the next update! Take a picture and upload your photo [here](:prove_it_link:).\n\rLet me know if I can help you, :first_name:.\n\r:sender_name:",
            'pro_tip' => null,
            'signoff' => null,
        ],
        [
            'type' => 'reminder',
            'key' => '1',
            'label' => 'Reminder for first submission due',
            'subject' => 'Do you have any more :reportback_noun:?',
            'body' => "Hey, :first_name:!\n\rJust a reminder that your next update is due :leaderboard_msg_day-1: before 10:00 PM EST. If you want to see yourself on the leaderboard, [upload a photo](:prove_it_link:) showing you and all :reportback_noun: :reportback_verb:.\n\rOn :leaderboard_msg_day:, I will send you the updated standings.\n\rLet me know if I can help, :first_name:!\n\r:sender_name:",
            'pro_tip' => null,
            'signoff' => null,
        ],
        [
            'type' => 'reminder',
            'key' => '2',
            'label' => 'Reminder for submission photo due',
            'subject' => 'Don’t forget to send us your :campaign_title: competition photo!',
            'body' => ":first_name:\n\rYour next update is due tonight before 10pm est, so if you want to make the leaderboard and see your name featured, [upload your photo](:prove_it_link:) with all your :reportback_noun: :reportback_verb:.\n\rCan’t wait to see it!\n\r:sender_name:",
            'pro_tip' => null,
            'signoff' => null,
        ],
        [
            'type' => 'reminder',
            'key' => '3',
            'label' => 'Almost over reminder',
            'subject' => 'This :campaign_title: competition is almost over, :first_name:!',
            'body' => "Last call: The final deadline for this competition is this :leaderboard_msg_day-1: night before 10:00 PM EST!\n\rWhen you’re ready, [upload your final photo](:prove_it_link:) showing all your :reportback_noun: :reportback_verb:. If you’re updating your submission with a new photo, simply click “add another photo” and write in how many :reportback_noun: you :reportback_verb:.\n\rLooking forward to seeing your final pic, :first_name:!\n\r:sender_name:",
            'pro_tip' => null,
            'signoff' => null,
        ],
        [
            'type' => 'reminder',
            'key' => '4',
            'label' => 'Last minute reminder',
            'subject' => 'LAST CHANCE! The :campaign_title: competition Deadline is now!',
            'body' => ":first_name:,\n\rThe :campaign_title: Competition closes at 10:00 PM EST TONIGHT. Take this moment to [upload your final photo](:prove_it_link:) clearly showing you and all :reportback_noun: :reportback_verb:.\n\rI will send the final results tomorrow, so keep your fingers crossed. Thanks for doing an awesome job to make an impact!\n\r:sender_name:",
            'pro_tip' => null,
            'signoff' => null,
        ],
        [
            'type' => 'leaderboard',
            'key' => '1',
            'label' => 'Leaderboard update',
            'subject' => '1st :campaign_title: Leaderboard Update',
            'body' => "Hello Competitors,\n\rHere is your first official :campaign_title: competition update! The competition ends on :end_date:. Finish in the top 3 in :reportback_noun: :reportback_verb: and win:\n\r- 1st place: ­ $100 amex card\r\n- 2nd place: ­ $50 amex card\r\n- 3rd place: ­ $25 amex card\n\rTwo more weeks to increase your number of :reportback_noun: :reportback_verb: to move up the leaderboard! [Upload your photos here](:prove_it_link:).\n\r:pro_tip:\n\rNext :reportback_noun: will be due :leaderboard_msg_day-1: before 10pm est.\n\rHere is the leaderboard! Shoutouts to the top 3 below:",
            'pro_tip' => null,
            'signoff' => null,
        ],
        [
            'type' => 'leaderboard',
            'key' => '2',
            'label' => 'Leaderboard update 2',
            'subject' => 'Leaderboard update #2 for the :campaign_title: competition!',
            'body' => "Hello, competitors-- \n\r1 more week! This :campaign_title: competition ends on :end_date:, so it’s time to make your mark.\n\r:pro_tip:\n\rA final photo with your :reportback_noun: will be due :leaderboard_msg_day-1: before 10pm EST. [Upload yours here](:prove_it_link:).\n\rHere is the leaderboard! Shoutouts to the top 3 below:\n\r1 more week to make your mark and climb up the leaderboard!",
            'pro_tip' => null,
            'signoff' => '1 more week to make your mark and climb up the leaderboard!',
        ],
        [
            'type' => 'leaderboard',
            'key' => '3',
            'label' => 'Final leaderboard update',
            'subject' => 'Here are the :campaign_title: competition winners!',
            'body' => "This is it, the final leaderboard and results. Thank you for spending these last 3 weeks, working hard not only to climb the leaderboard, but also to affect lives around you and make the world a better place.\n\rHere is your final leaderboard. Pics, prizes and honorable mentions below:\n\r",
            'pro_tip' => null,
            'signoff' => null,
        ],
    ];

    /**
     * Get all default messages.
     *
     * @return array
     */
    public static function defaults()
    {
        return static::$defaultMessages;
    }

    /**
     * Get a specific message input.
     *
     * @param  array  $message
     * @param  string  $field
     * @return string
     */
    public static function get($message, $field)
    {
        $old = app('request')->old('messages');

        if ($old) {
            return $old[$message['type']][$message['key']][$field];
        }

        return $message[$field];
    }

    /**
     * Get unique attribute for element by contactination a few parameters.
     *
     * @param  array|\Gladiator\Models\Message  $message
     * @param  string $field
     * @return string
     */
    public function getAttribute($message, $field)
    {
        return 'messages[' . $message['type'] . '][' . $message['key'] . ']['. $field .']';
    }
}
