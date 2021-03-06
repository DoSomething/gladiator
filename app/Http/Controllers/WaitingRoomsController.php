<?php

namespace Gladiator\Http\Controllers;

use Gladiator\Models\Contest;
use Gladiator\Services\Manager;
use Gladiator\Models\WaitingRoom;
use Gladiator\Http\Requests\SplitRequest;
use Gladiator\Http\Requests\WaitingRoomRequest;
use Gladiator\Repositories\UserRepositoryContract;

class WaitingRoomsController extends Controller
{
    /**
     * UserRepository instance.
     *
     * @var \Gladiator\Repositories\UserRepositoryContract
     */
    protected $repository;

    /**
     * manager instance.
     *
     * @var \Gladiator\Services\CompetitionsController
     */
    protected $manager;

    /**
     * Create new WaitingRoomsController instance.
     */
    public function __construct(UserRepositoryContract $repository, Manager $manager)
    {
        $this->repository = $repository;
        $this->manager = $manager;

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
        $rooms = WaitingRoom::all();

        return view('waitingrooms.index', compact('rooms'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(WaitingRoomRequest $request)
    {
        WaitingRoom::create($request->all());

        return redirect()->back()->with('status', 'Waiting room has been saved!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \Gladiator\Models\WaitingRoom  $room
     * @return \Illuminate\Http\Response
     */
    public function show(WaitingRoom $room)
    {
        $users = [];

        $contest = Contest::find($room->contest_id);

        $ids = $room->users->pluck('northstar_id')->toArray();

        if ($ids) {
            $users = $this->repository->getAll($ids);
        }

        return view('waitingrooms.show', compact('room', 'contest', 'users'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Gladiator\Models\WaitingRoom  $room
     * @return \Illuminate\Http\Response
     */
    public function edit(WaitingRoom $room)
    {
        return view('waitingrooms.edit', compact('room'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Gladiator\Models\WaitingRoom  $room
     * @return \Illuminate\Http\Response
     */
    public function update(WaitingRoomRequest $request, WaitingRoom $room)
    {
        $room->fill($request->all())->save();

        return redirect()->route('waitingrooms.show', $room->id)->with('status', 'Waiting room has been updated!');
    }

    /**
     * Show the form for splitting the waiting room
     *
     * @param  \Gladiator\Models\WaitingRoom  $room
     * @return \Illuminate\Http\Response
     */
    public function showSplitForm(WaitingRoom $room)
    {
        $split = $room->getSplit();

        return view('waitingrooms.split', compact('split', 'room'));
    }

    /**
     * Split the waiting room.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Gladiator\Models\WaitingRoom  $room
     * @return \Illuminate\Http\Response
     */
    public function split(SplitRequest $request, WaitingRoom $room)
    {
        $split = $room->getSplit($request->competition_max);
        $contest = Contest::find($room->contest_id);
        $room->saveSplit($contest, $split, $request);

        return redirect()->route('contests.show', $room->contest_id)->with('status', 'Waiting Room has been split!');
    }

    /**
     * Download a CSV export of all users.
     *
     * @param  \Gladiator\Models\WaitingRoom  $room
     * @return void
     */
    public function export(WaitingRoom $room)
    {
        $users = $this->manager->getModelUsers($room);

        $csv = $this->manager->exportUsersCsv($users);

        $csv->output('contest_' . $room->contest_id . '-' . 'waitingroom_' . $room->id . '-users.csv');
    }
}
