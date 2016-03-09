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
            // @TODO: More to come...
        ];
    }
}
