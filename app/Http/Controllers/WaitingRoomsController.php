<?php

namespace Gladiator\Http\Controllers;

use Gladiator\Models\Contest;
use Gladiator\Models\WaitingRoom;
use Gladiator\Http\Requests\CompetitionRequest;
use Gladiator\Http\Requests\WaitingRoomRequest;

class WaitingRoomsController extends Controller
{
    /**
     * Create new WaitingRoomsController instance.
     */
    public function __construct()
    {
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
        $contest = Contest::find($room->contest_id);

        return view('waitingrooms.show', compact('room', 'contest'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Gladiator\Models\WaitingRoom  $room
     * @return \Illuminate\Http\Response
     */
    public function edit(WaitingRoom $room)
    {
        // Convert the dates to Date objects so we can use them as default values.
        $room->signup_start_date = new \DateTime($room->signup_start_date);
        $room->signup_end_date = new \DateTime($room->signup_end_date);

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

        return redirect()->back()->with('status', 'Waiting room has been updated!');
    }

    /**
     * Show the form for splitting the waiting room
     *
     * @param  \Gladiator\Models\WaitingRoom  $room
     * @return \Illuminate\Http\Response
     */
    public function showSplitForm(WaitingRoom $room)
    {
        $split = $room->getDefaultSplit();

        return view('waitingrooms.split', compact('split', 'room'));
    }

    /**
     * Split the waiting room.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Gladiator\Models\WaitingRoom  $room
     * @return \Illuminate\Http\Response
     */
    public function split(CompetitionRequest $request, WaitingRoom $room)
    {
        $split = $room->getDefaultSplit();
        $room->saveSplit($request->all(), $split);

        return redirect()->route('waitingrooms.index')->with('status', 'Waiting Room has been split!');
    }
}
