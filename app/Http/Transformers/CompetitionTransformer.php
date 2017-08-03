<?php

namespace Gladiator\Http\Transformers;

use Gladiator\Models\Competition;
use League\Fractal\TransformerAbstract;

class CompetitionTransformer extends TransformerAbstract
{
    /**
     * Transform resource data.
     *
     * @param  Contest  $contest
     * @return array
     */
    public function transform(Competition $competition)
    {
        return [
            'id' => $competition->id,
            'competition_dates' => [
                'start_date' => $competition->competition_start_date->toIso8601String(),
                'end_date' => $competition->competition_end_date->toIso8601String(),
            ],
            'leaderboard_msg_day' => jddayofweek($competition->leaderboard_msg_day, 1),
            'rules' => $competition->rules_url,
            'users' => $competition->users->pluck('northstar_id'),
            'subscribed_users' => $competition->subscribers->pluck('northstar_id'),
            'unsubscribed_users' => $competition->unsubscribers->pluck('northstar_id'),
            'created_at' => $competition->created_at->toIso8601String(),
            'updated_at' => $competition->updated_at->toIso8601String(),
            // @TODO - figure out if this should be on the comptition or the message.
            'featured_reportback' => [],
            'leaderboard_photos' => [],
        ];
    }
}
