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
            'campaign' => [
                'id' => $contest->campaign_id,
                'campaign_run' => [
                    'id' => $contest->campaign_run_id,
                ],
            ],
            'waiting_room' => [
                'open' => $contest->waitingRoom->isOpen(),
                'signup_dates' => [
                    'start' => $contest->waitingRoom->signup_start_date->toIso8601String(),
                    'end' => $contest->waitingRoom->signup_end_date->toIso8601String(),    
                ],
            ],
        ];
    }
}
