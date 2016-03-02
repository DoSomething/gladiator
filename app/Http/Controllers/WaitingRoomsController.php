<?php

namespace Gladiator\Http\Controllers;

use Illuminate\Http\Request;
use Gladiator\Models\WaitingRoom;

class WaitingRoomsController extends Controller
{
    private $validationRules = [
        'campaign_id' => 'required|numeric',
        'campaign_run_id' => 'required|numeric',
        'signup_start_date' => 'required|date',
        'signup_end_date' => 'required|date',
    ];

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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('waitingrooms.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->validationRules);

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
        return view('waitingrooms.show', compact('room'));
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
    public function update(Request $request, WaitingRoom $room)
    {
        $this->validate($request, $this->validationRules);

        $room->fill($request->all())->save();

        return redirect()->back()->with('status', 'Waiting room has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Gladiator\Models\WaitingRoom  $room
     * @return \Illuminate\Http\Response
     */
    public function destroy(WaitingRoom $room)
    {
        $room->delete();

        return redirect()->route('waitingrooms.index')->with('status', 'Waiting Room has been deleted!');
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
    public function split(StoreCompetitionRequest $request, WaitingRoom $room)
    {
        $split = $room->getDefaultSplit();
        $room->saveSplit($request->all(), $split);

        return redirect()->route('waitingrooms.index')->with('status', 'Waiting Room has been split!');
    }
}
