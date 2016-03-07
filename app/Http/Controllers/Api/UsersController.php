<?php

namespace Gladiator\Http\Controllers\Api;

use Gladiator\Models\User;
use Gladiator\Models\WaitingRoom;
use Gladiator\Services\Registrar;
use Gladiator\Http\Requests\UserRequest;
use Gladiator\Http\Transformers\UserTransformer;

class UsersController extends ApiController
{
    /**
     * @var \Gladiator\Services\Registrar
     */
    protected $registrar;

    /**
     * @var \Gladiator\Http\Transformers\UserTransformer
     */
    protected $transformer;

    /**
     * Create new UsersController instance.
     */
    public function __construct(Registrar $registrar, UserTransformer $transformer)
    {
        parent::__construct();

        $this->registrar = $registrar;
        $this->transformer = $transformer;
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
            // @TODO: maybe add more detail to response to indicate user already in a room?
            return $this->item($user);
        }

        $waitingRoom->users()->attach($user->id);
            // @TODO: maybe add more detail to response to indicate which room user was added to?
            return $this->item($user);
    }
}
