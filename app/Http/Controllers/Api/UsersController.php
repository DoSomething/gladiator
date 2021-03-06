<?php

namespace Gladiator\Http\Controllers\Api;

use Log;
use Gladiator\Models\User;
use Gladiator\Models\Contest;
use Gladiator\Services\Manager;
use Gladiator\Services\Registrar;
use Gladiator\Http\Requests\UserRequest;
use Gladiator\Http\Transformers\UserTransformer;
use Gladiator\Repositories\UserRepositoryContract;

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
     * @var Gladiator\Services\Manager;
     */
    protected $manager;

    /**
     * UserRepository instance.
     *
     * @var \Gladiator\Repositories\UserRepositoryContract
     */
    protected $repository;

    /**
     * Create new UsersController instance.
     */
    public function __construct(Registrar $registrar, Manager $manager, UserRepositoryContract $repository)
    {
        $this->registrar = $registrar;
        $this->transformer = new UserTransformer;
        $this->manager = $manager;
        $this->repository = $repository;

        $this->middleware('auth.api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(UserRequest $request)
    {
        $user = User::find($request['id']);

        if (is_null($user)) {
            return response()->json([]);
        }

        $contest = $this->getContest($request['campaign_id'], $request['campaign_run_id']);

        if ($contest) {
            $roomAssignment = $user->waitingRooms()->find($contest->waitingRoom->id);

            // If a user is in a waiting room attach the waitingRoom to the users object
            if ($roomAssignment) {
                $user->setAttribute('roomAssignment', $roomAssignment);
            }

            $competitionAssignment = $this->manager->findUserInCompetition($contest, $user->northstar_id);

            // If a user is in a competition for a given contest attach the competition to the users object
            if ($competitionAssignment) {
                $user->setAttribute('competitionAssignment', $competitionAssignment);
            }

            return $this->item($user);
        } else {
            return response()->json([
                'error' => [
                    'code' => 404,
                    'message' => 'Contest Not Found',
                ],
            ]);
        }
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

        Log::debug('Gladiator\Http\Controllers\Api\UsersController -- Storing user', ['user' => $user]);

        $contest = $this->getContest($request['campaign_id'], $request['campaign_run_id']);

        $competitionAssignment = $this->manager->findUserInCompetition($contest, $user->northstar_id);

        if ($competitionAssignment) {
            return response()->json([
                'error' => [
                    'code' => 422,
                    'message' => 'User Already In Competition',
                ],
            ]);
        }

        $roomAssignment = $user->waitingRooms()->find($contest->waitingRoom->id);

        if ($roomAssignment) {
            // @TODO: maybe add more detail to response to indicate user already in a room?
            return $this->item($user);
        }

        $contest->waitingRoom->users()->attach($user->northstar_id);
        $contest = $this->manager->appendCampaign($contest);

        // Fire off welcome Email
        $params = [
            'type' => 'welcome',
            'key' => 0,
            'contest_id' => $contest->id,
        ];

        $this->manager->sendEmail($user, $contest, $params);

        // @TODO: maybe add more detail to response to indicate which room user was added to?
        return $this->item($user);
    }

    /**
     * Return contest for a given campaignId & campaignRunId
     *
     * @param int                   $campaign_id
     * @param int                   $campaign_run_id
     * @return app\Models\Contest
     */
    public function getContest($campaign_id, $campaign_run_id)
    {
        $contest = Contest::with(['waitingRoom', 'competitions'])->where('campaign_id', '=', $campaign_id)
                            ->where('campaign_run_id', '=', $campaign_run_id)
                            ->firstOrFail();

        return $contest;
    }
}
