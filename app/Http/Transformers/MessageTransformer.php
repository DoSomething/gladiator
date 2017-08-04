<?php

namespace Gladiator\Http\Transformers;

use Gladiator\Models\Message;
use League\Fractal\TransformerAbstract;

class MessageTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        'featuredReportbacks',
        'leaderboardPhotos',
    ];

    /**
     * Transform resource data.
     *
     * @param  Contest  $contest
     * @return array
     */
    public function transform(Message $message)
    {
        return [
            'id' => $message->id,
            'contest_id' => $message->contest_id,
            'type' => [
                'name' => $message->type,
                'key' => $message->key,
            ],
            'label' => $message->label,
            'subject' => $message->subject,
            'body' => $message->body,
            'signoff' => $message->signoff,
            'pro_tip' => $message->pro_tip,
            'show_images' => $message->show_images,
            'created_at' => $message->created_at->toIso8601String(),
            'updated_at' => $message->updated_at->toIso8601String(),
        ];
    }

    /**
     * Include Featured Reportbacks
     *
     * @return League\Fractal\CollectionResource
     */
    public function includeFeaturedReportbacks(Message $message)
    {
        $featuredReportbacks = $message->featuredReportbacks;

        return $this->collection($featuredReportbacks, new FeaturedReportbackTransformer);
    }

    /**
     * Include Leaderboard Photos
     *
     * @return League\Fractal\CollectionResource
     */
    public function includeLeaderboardPhotos(Message $message)
    {
        $leaderboardPhotos = $message->leaderboardPhotos;

        return $this->collection($leaderboardPhotos, new LeaderboardPhotoTransformer);
    }
}
