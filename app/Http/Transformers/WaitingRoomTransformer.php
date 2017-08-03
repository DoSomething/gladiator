<?php

namespace Gladiator\Http\Transformers;

use Gladiator\Models\WaitingRoom;
use League\Fractal\TransformerAbstract;

class WaitingRoomTransformer extends TransformerAbstract
{
    /**
     * Transform resource data.
     *
     * @param  Contest  $contest
     * @return array
     */
    public function transform(WaitingRoom $waitingRoom)
    {
        return [
            'open' => $waitingRoom->isOpen(),
            'signup_dates' => [
                'start' => $waitingRoom->signup_start_date->toIso8601String(),
                'end' => $waitingRoom->signup_end_date->toIso8601String(),
            ],
            'users' => $waitingRoom->users->pluck('northstar_id'),
            'created_at' => $waitingRoom->created_at->toIso8601String(),
            'updated_at' => $waitingRoom->updated_at->toIso8601String(),
        ];
    }
}
