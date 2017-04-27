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
            'id' => $waitingRoom->contest_id,
            'competition_start_date' => $waitingRoom->signup_start_date,
            'competition_end_date' => $waitingRoom->signup_end_date,
        ];
    }
}
