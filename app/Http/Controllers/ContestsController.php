<?php

namespace Gladiator\Http\Controllers;

use Gladiator\Models\Contest;
use Gladiator\Models\User;
use Gladiator\Services\Manager;
use Gladiator\Services\Registrar;
use Gladiator\Http\Requests\ContestRequest;
use Gladiator\Http\Requests\SignupUserRequest;
use Gladiator\Repositories\MessageRepository;

class ContestsController extends Controller
{
    /**
     * Create new ContestsController instance.
     */
    public function __construct(Manager $manager, Registrar $registrar)
    {
        $this->manager = $manager;
        $this->registrar = $registrar;

        $this->middleware('auth');
        $this->middleware('role:admin,staff');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contests = Contest::all();

        $contests = $this->manager->appendCampaign($contests);

        return view('contests.index', compact('contests'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('contests.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContestRequest $request)
    {
        $contest = Contest::create([
            'campaign_id' => $request->input('campaign_id'),
            'campaign_run_id' => $request->input('campaign_run_id'),
            'sender_email' => $request->input('sender_email'),
            'sender_name' => $request->input('sender_name'),
        ]);

        $contest->waitingRoom->fill($request->only(['signup_start_date', 'signup_end_date']))->save();

        $repository = new MessageRepository;
        $repository->createMessagesForContest($contest, $request->input('messages'));

        return redirect()->action('ContestsController@show', $contest->id)->with('status', 'Contest has been saved!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \Gladiator\Models\Competition  $competition
     * @return \Illuminate\Http\Response
     */
    public function show(Contest $contest)
    {
        $contest = $this->manager->collectContestInfo($contest->id);

        $contest = $this->manager->appendCampaign($contest);

        return view('contests.show', compact('contest'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Gladiator\Models\WaitingRoom  $room
     * @return \Illuminate\Http\Response
     */
    public function edit(Contest $contest)
    {
        return view('contests.edit', compact('contest'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Gladiator\Models\WaitingRoom  $room
     * @return \Illuminate\Http\Response
     */
    public function update(ContestRequest $request, Contest $contest)
    {
        $dateParams = ['signup_start_date', 'signup_end_date'];

        $contest->fill($request->except($dateParams))->save();
        $contest->WaitingRoom->fill($request->only($dateParams))->save();

        return redirect()->back()->with('status', 'Contest has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Gladiator\Models\WaitingRoom  $room
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contest $contest)
    {
        $contest->delete();

        return redirect()->route('contests.index')->with('status', 'Contest has been deleted!');
    }

    /**
     * Download the CSV export of all users.
     *
     * @param  \Gladiator\Models\Contest $contest
     * @return \League\Csv\ $csv
     */
    public function export(Contest $contest)
    {
        $csv = $contest->getCSVExport();
        $csv->output('contest' . $contest->id . '.csv');
    }

    /**
     * Grab the form to add a user retroactively.
     *
     * @param  \Gladiator\Models\Contest $contest
     * @return  \Illuminate\Http\Response
     */
    public function signupForm(Contest $contest)
    {
        $contest = $contest->load(['waitingroom', 'competitions']);

        return view('contests.signup', compact('contest'));
    }

    /**
     * The post request to add a user retroactively.
     *
     * @param  SignupUserRequest $request
     * @return \Illuminate\Http\Response
     */
    public function signupUser(SignupUserRequest $request)
    {
        $user = $this->registrar->findUserAccount($request->all());

        if (! $user instanceof User) {
            $user = $this->registrar->createUser($user);
        }

        // Add the user to a competition or waiting room, but only if not already in it.
        if ($request->has('competition_id')) {
            $this->manager->addUserToRoom('competitions', $request->competition_id, $user);
        } else {
            $this->manager->addUserToRoom('waitingrooms', $request->waitingroom_id, $user);
        }

        return redirect()->route('contests.show', 1)->with('status', 'Allllllright, we added that late punk!');
    }
}
