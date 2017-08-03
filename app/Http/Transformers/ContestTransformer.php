<?php

namespace Gladiator\Http\Transformers;

use Gladiator\Models\Contest;
use League\Fractal\TransformerAbstract;

class ContestTransformer extends TransformerAbstract
{
    /**
     * Transform resource data.
     *
     * @param  Contest  $contest
     * @return array
     */
    public function transform(Contest $contest)
    {
        return [
            'id' => $contest->id,
            'campaign_id' => $contest->campaign_id,
            'campaign_run_id' => $contest->campaign_run_id,
            'sender' => [
                "name" => $contest->sender_name,
                "email" => $contest->sender_email,
            ],
            'created_at' => $contest->created_at->toIso8601String(),
            'updated_at' => $contest->updated_at->toIso8601String(),
            'waiting_room' => [
                'open' => $contest->waitingRoom->isOpen(),
                'signup_dates' => [
                    'start' => $contest->waitingRoom->signup_start_date->toIso8601String(),
                    'end' => $contest->waitingRoom->signup_end_date->toIso8601String(),
                ],
                'users' => $contest->waitingRoom->users->toArray(),
                'created_at' => $contest->waitingRoom->created_at->toIso8601String(),
                'updated_at' => $contest->waitingRoom->updated_at->toIso8601String(),
            ],
        ];
    }
}
