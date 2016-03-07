<?php

namespace Gladiator\Http\Controllers\Api;

use Gladiator\Models\User;
use Gladiator\Models\WaitingRoom;
use Gladiator\Services\Registrar;
use Gladiator\Http\Requests\UserRequest;

class UsersController extends ApiController
{
    /**
     * Registrar instance.
     *
     * @var \Gladiator\Services\Registrar
     */
    protected $registrar;

    /**
     * Create new UsersController instance.
     */
    public function __construct(Registrar $registrar)
    {
        $this->registrar = $registrar;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Gladiator\Http\Requests\UserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $account = $this->registrar->findUserAccount($request->all());

        if (! $account instanceof User) {
            $credentials = $request->all();
            $credentials['id'] = $account;

            $user = $this->registrar->createUser($credentials);
        } else {
            $user = $account;
        }

        $waitingRoom = WaitingRoom::where('campaign_id', '=', $request['campaign_id'])
                                    ->where('campaign_run_id', '=', $request['campaign_run_id'])
                                    ->firstOrFail();

        $roomAssignment = $user->waitingRooms()->find($waitingRoom->id);

        if ($roomAssignment) {
            // @TODO: return Transformed response via Fractal
            return 'User already assigned to this waiting room!';
        }

        $waitingRoom->users()->attach($user->id);

        // @TODO: return Transformed response via Fractal
        return 'User was not in waiting room, so they have been assigned to it!';
    }
}
