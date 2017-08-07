<?php

namespace Gladiator\Http\Transformers;

use Gladiator\Models\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        'waitingRooms',
        'competitions',
    ];

    /**
     * Transform resource data.
     *
     * @param  User  $user
     * @return array
     */
    public function transform(User $user)
    {
        return [
            'id' => (string) $user->northstar_id,
            'created_at' => $user->created_at->toIso8601String(),
            'updated_at' => $user->updated_at->toIso8601String(),
        ];
    }

    /**
     * Include the Waiting Rooms the user is assigned to.
     *
     * @return League\Fractal\CollectionResource
     */
    public function includeWaitingRooms(User $user)
    {
        $waitingRoom = $user->waitingRooms;

        return $this->collection($waitingRoom, new WaitingRoomTransformer);
    }

    /**
     * Include the Comptetitions that the user is assigned to.
     *
     * @return League\Fractal\CollectionResource
     */
    public function includeCompetitions(User $user)
    {
        $competition = $user->competitions;

        return $this->collection($competition, new CompetitionTransformer);
    }
}
