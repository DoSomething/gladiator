<?php

namespace Gladiator\Http\Transformers;

use Gladiator\Models\WaitingRoom;
use League\Fractal\TransformerAbstract;

class WaitingRoomTransformer extends TransformerAbstract
{
    /**
     * Transform resource data.
     *
     * @param  WaitingRoom  $waitingRoom
     * @return array
     */
    public function transform(WaitingRoom $waitingRoom)
    {
        // @TODO: organize response better.

        return [
            'id' => $waitingRoom->id,
            'campaign' => [
                'id' => $waitingRoom->campaign_id,
                'campaign_run' => [
                    'id' => $waitingRoom->campaign_run_id,
                ]
            ],
            'signup_dates' => [
                'start' => $waitingRoom->signup_start_date->toISO8601String(),
                'end' => $waitingRoom->signup_end_date->toISO8601String(),
            ],
            'created_at' => $waitingRoom->created_at->toISO8601String(),
            'updated_at' => $waitingRoom->updated_at->toISO8601String(),
        ];
    }
}
