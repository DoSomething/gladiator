<?php

namespace Gladiator\Http\Transformers;

use League\Fractal\TransformerAbstract;
use Gladiator\Models\FeaturedReportback;

class FeaturedReportbackTransformer extends TransformerAbstract
{
    /**
     * Transform resource data.
     *
     * @param  Contest  $contest
     * @return array
     */
    public function transform(FeaturedReportback $featuredReportback)
    {
        return [
            'id' => $featuredReportback->id,
            'competition_id' => $featuredReportback->competition_id,
            'message_id' => $featuredReportback->message_id,
            'reportback' => [
                'id' => $featuredReportback->reportback_id,
                'item_id' => $featuredReportback->reportback_item_id,
            ],
            'shoutout' => $featuredReportback->shoutout,
            'created_at' => $featuredReportback->created_at->toIso8601String(),
            'updated_at' => $featuredReportback->updated_at->toIso8601String(),
        ];
    }
}
