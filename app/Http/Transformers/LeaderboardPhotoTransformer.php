<?php

namespace Gladiator\Http\Transformers;

use Gladiator\Models\LeaderboardPhoto;
use League\Fractal\TransformerAbstract;

class LeaderboardPhotoTransformer extends TransformerAbstract
{
    /**
     * Transform resource data.
     *
     * @param  Contest  $contest
     * @return array
     */
    public function transform(LeaderboardPhoto $leaderboardPhoto)
    {
        return [
            'id' => $leaderboardPhoto->id,
            'competition_id' => $leaderboardPhoto->competition_id,
            'message_id' => $leaderboardPhoto->message_id,
            'northstar_id' => $leaderboardPhoto->northstar_id,
            'reportback' => [
                'id' => $leaderboardPhoto->reportback_id,
                'item_id' => $leaderboardPhoto->reportback_item_id,
            ],
            'created_at' => $leaderboardPhoto->created_at->toIso8601String(),
            'updated_at' => $leaderboardPhoto->updated_at->toIso8601String(),
        ];
    }
}
