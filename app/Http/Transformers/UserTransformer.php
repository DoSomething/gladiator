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
        'waitingRoom',
        'competition'
    ];

    /**
     * Transform resource data.
     *
     * @param  User  $user
     * @return array
     */
    public function transform(User $user)
    {
        // dump("UserTransformer here");
        return [
            'id' => (string) $user->northstar_id,
            'first_name' => null,
            'last_name' => null,
            'email' => null,
            'mobile' => null,
            'signup' => null,
            'reportback' => null,
            'created_at' => $user->created_at->toIso8601String(),
            'updated_at' => $user->updated_at->toIso8601String(),
        ];
    }


    /**
     * Include Contest
     *
     * @return League\Fractal\ItemResource
     */
    public function includeWaitingRoom(User $user)
    {
        $waitingRoom = $user->roomAssignment;

        if ($waitingRoom) {
            return $this->item($waitingRoom, new WaitingRoomTransformer);
        }
        else {
            return null;
        }
    }

    /**
     * Include Contest
     *
     * @return League\Fractal\ItemResource
     */
    public function includeCompetition(User $user) {
        $competition = $user->competitionAssignment;

        if ($competition) {
            return $this->item($competition, new CompetitionTransformer);
        } else {
            return null;
        }

    }
}
