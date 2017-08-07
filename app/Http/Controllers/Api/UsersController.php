<?php

namespace Gladiator\Http\Controllers\Api;

use Log;
use Gladiator\Models\User;
use Illuminate\Http\Request;
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
    public function index(Request $request)
    {
        $query = $this->newQuery(User::class);
        $filters = $request->query('filter');

        if (array_key_exists('campaign_id', $filters)) {
            $contests = Contest::where('campaign_id', $filters['campaign_id'])->get();

            $query = $query->with(['waitingRooms' => function ($query) use ($filters, $contests) {
                $query->wherein('contest_id', $contests->pluck('id'));
            }]);

            $query = $query->with(['competitions' => function ($query) use ($filters, $contests) {
                $query->wherein('contest_id', $contests->pluck('id'));
            }]);
        }

        if (array_key_exists('campaign_run_id', $filters)) {
            $contests = Contest::where('campaign_run_id', $filters['campaign_run_id'])->get();

            $query = $query->with(['waitingRooms' => function ($query) use ($filters, $contests) {
                $query->wherein('contest_id', $contests->pluck('id'));
            }]);

            $query = $query->with(['competitions' => function ($query) use ($filters, $contests) {
                $query->wherein('contest_id', $contests->pluck('id'));
            }]);
        }

        $query = $this->filter($query, $filters, User::$indexes);

        return $this->paginatedCollection($query, $request);
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
