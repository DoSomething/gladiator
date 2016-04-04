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
            'subject' => 'Welcome, [First Name]!',
            'body' => "Woohoo, so glad you signed up for my [Campaign Name] competition, [First Name]! Feel free to get a head start on the competition and begin today. \n\rI will be in touch with you with more info in the next few days. Excited to watch you climb the leaderboard and crush the competition! \n\r[Name of Staff]",
            'pro_tip' => null,
        ],
        [
            'type' => 'checkin',
            'key' => '1',
            'label' => 'Where are you? Check status',
            'subject' => 'Is everything ok, [First Name]?',
            'body' => "I noticed you didn’t send in a picture of your [reportback item] into the DoSomething site last update. Just wanted to see if everything is ok! Even if you can't hit your goal, just a few [reportback items] can make a huge difference! \n\rIf you are able, you still have until Sunday night for the next update! Take a picture and upload to our site right here [link to campaign]. \n\rNeed a little inspiration? Check out the photo below as a great example! Let me know if there’s any way I can help you, $%First Name%!",
            'pro_tip' => null,
        ],
        [
            'type' => 'reminder',
            'key' => '1',
            'label' => 'Reminder for first submission due',
            'subject' => 'Hey [First Name]!',
            'body' => "Just wanted to send along some more info about the [Campaign Name] Competition you signed up for. The rules are simple: \n\r1. The more [Report Back Noun] [Report Back Verb], the higher you move up the leaderboard \n\r2. You must prove it by uploading a selfie, clearly showing you and all [Report Back Noun] [Report Back Verb] each Sunday night \n\r3. The competitor with the most [Report Back Noun] [Report Back Verb] by the competition deadline of [Competition End Date], wins $100 on an amex gift card. 2nd ­ $50, 3rd ­ $25 \n\rYour first update is due on [Leaderboard Day ­1] before 10pm est. If you have an update for me, and want to see yourself on [Leaderboard Day]’s leaderboard, simply click the blue icon below!",
            'pro_tip' =>null,
        ],
        [
            'type' => 'reminder',
            'key' => '2',
            'label' => 'Reminder to submit v1',
            'subject' => 'Do you have anymore [Report Back Noun]?',
            'body' => "[First Name] ­\n\rYour next update is due [Leaderboard Day ­1] before 10pm est. If you want to see yourself on the leaderboard, simply click on the icon below, then upload a selfie clearly showing you and all [Report Back Noun] [Report Back Verb] On Monday, I will send you the updated standings. \n\rLet me know if I can help, [First Name]! \n\r[Name of Staff]",
            'pro_tip' => null,
        ],
        [
            'type' => 'reminder',
            'key' => '3',
            'label' => 'Reminder to submit v2',
            'subject' => 'This Competition is Almost Over, [First Name]',
            'body' => "The final deadline for this competition is this Sunday night before 10pm EST! \n\rReady to upload a selfie now showing all your [Report Back Noun] [Report Back Verb]? Click the icon below. \n\rLooking forward to seeing your final pic, [First Name]!",
            'pro_tip' => null,
        ],
        [
            'type' => 'reminder',
            'key' => '4',
            'label' => 'Last minute reminder v1',
            'subject' => 'Send us your [Campaign Name] Competition Photo!',
            'body' => "[First Name]! \n\rThis is your friendly reminder that your next update is due tonight at 10pm est, so if you want to make the leaderboard and see your name featured, upload your selfie with all your [Report Back Noun] [Report Back Verb]. \n\rCan’t wait to see it! \n\r[Name of Staff]",
            'pro_tip' => null,
        ],
        [
            'type' => 'reminder',
            'key' => '5',
            'label' => 'Last minute reminder v2',
            'subject' => 'The Competition Deadline is Now!',
            'body' => "You have until tonight at 10pm EST to upload your final, badass selfie with all of your [Report Back Noun]. \n\rUpload your final selfie with your [Report Back Noun] below. Can’t wait to see how you did, [First Name]!",
            'pro_tip' => null,
        ],
        [
            'type' => 'leaderboard',
            'key' => '1',
            'label' => 'Leaderboard update',
            'subject' => '1st Leaderboard Update',
            'body' => "Hello Competitors, \n\rHere is your 1st official [Campaign Name] competition update! The competition ends on [Competition End Date]. Finish in the top 3 in [Report Back Noun] [Report Back Verb] and win: \n\r- 1st place ­ $100 amex card\r- 2nd place ­ $50 amex card \r- 3rd place ­ $25 amex card \n\rKeep collecting [Report Back Noun] for the next 2 weeks to move up the leaderboard! \n\rPro tip ­ [Contest Pro Tip] \n\rNext update selfie with your [Report Back Noun] will be due [Leaderboard Day ­ 1] before 10pm est. \n\rHere is the leaderboard! Top 3 and a shoutouts below: \n\r[Leaderboard] \n\r[1 Random Image w/ comment] \n\r[Top 3 competitor IMAGES w/comment] \n\r[#] more weeks to make your mark and climb up the leaderboard!",
            'pro_tip' => null,
        ],
        [
            'type' => 'leaderboard',
            'key' => '2',
            'label' => 'Final leaderboard update',
            'subject' => 'The Results Are In!',
            'body' => "This is it. The final leaderboard. Thank you for spending these last 3 weeks, battling not only to climb the leaderboard, but affecting so many lives around you in a truly impactful way. \n\rHere is your final leaderboard. Pics, prizes and honorable mentions below:",
            'pro_tip' => null,
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
