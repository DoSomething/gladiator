<?php

namespace Gladiator\Http\Transformers;

use Gladiator\Models\Contest;
use League\Fractal\TransformerAbstract;

class ContestTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        'waitingRoom',
        'competitions',
        'messages',
    ];

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
        ];
    }

    /**
     * Include Competitions
     *
     * @return League\Fractal\CollectionResource
     */
    public function includeCompetitions(Contest $contest)
    {
        $competitions = $contest->competitions;

        return $this->collection($competitions, new CompetitionTransformer);
    }

    /**
     * Include Waiting Room
     *
     * @return League\Fractal\ItemResource
     */
    public function includeWaitingRoom(Contest $contest)
    {
        $waitingRoom = $contest->waitingRoom;

        return $this->item($waitingRoom, new WaitingRoomTransformer);
    }

    /**
     * Include Messages
     *
     * @return League\Fractal\CollectionResource
     */
    public function includeMessages(Contest $contest)
    {
        // $competitions = $contest->competitions;
        $messages = $contest->messages;

        return $this->collection($messages, new MessageTransformer);
    }
}
