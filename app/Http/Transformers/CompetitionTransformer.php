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
            'competition_start_date' => $competition->competition_start_date,
            'competition_end_date' => $competition->competition_end_date,
        ];
    }
}
