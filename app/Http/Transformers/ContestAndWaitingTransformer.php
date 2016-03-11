<?php

namespace Gladiator\Http\Transformers;

use Gladiator\Models\Contest;
use League\Fractal\TransformerAbstract;

class ContestAndWaitingTransformer extends TransformerAbstract
{
    /**
     * Transform resource data.
     *
     * @param  Array  data
     * @return array
     */
    public function transform($data)
    {
        $waitingRoom = $data['waitingRoom'];
        $contest = $data['contest'];

        return [
            'signups_open' => $waitingRoom->isOpen(),
            'signup_start' => $waitingRoom->signup_start_date->toIso8601String(),
            'signup_end' => $waitingRoom->signup_end_date->toIso8601String(),
            'contest_id' => $contest->id,
            'campaign_id' => $contest->campaign_id,
            'campaign_run_id' => $contest->campaign_run_id,
        ];
    }
}
