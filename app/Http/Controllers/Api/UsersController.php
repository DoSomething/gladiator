<?php

namespace Gladiator\Http\Controllers\Api;

use Gladiator\Models\User;
use Gladiator\Models\Contest;
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
    public function __construct(Registrar $registrar)
    {
        $this->registrar = $registrar;
        $this->transformer = new UserTransformer;

        $this->middleware('auth.api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // @TODO: temp for now, likely want to use repository and transform.
        return User::all();
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

        if ($account instanceof User) {
            $user = $account;
        } else {
            $credentials = $request->all();
            $credentials['id'] = $account->id;
            unset($credentials['term']);

            $user = $this->registrar->createUser((object) $credentials);
        }

        $contest = Contest::with(['waitingRoom', 'competitions'])->where('campaign_id', '=', $request['campaign_id'])
                            ->where('campaign_run_id', '=', $request['campaign_run_id'])
                            ->firstOrFail();

        $roomAssignment = $user->waitingRooms()->find($contest->waitingRoom->id);

        if ($roomAssignment) {
            // @TODO: maybe add more detail to response to indicate user already in a room?
            return $this->item($user);
        }

        $contest->waitingRoom->users()->attach($user->id);

        // @TODO: maybe add more detail to response to indicate which room user was added to?
        return $this->item($user);
    }
}
