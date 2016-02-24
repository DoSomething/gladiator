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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rooms = WaitingRoom::all();

        return view('waitingrooms.index')->with(compact('rooms'));
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

        $input = $request->all();

        WaitingRoom::create($input);

        return redirect()->back()->with('status', 'Waiting room has been saved!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(WaitingRoom $room)
    {
        return view('waitingrooms.show')->with(compact('room'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(WaitingRoom $room)
    {
        // Convert the dates to Date objects so we can use them as default values.
        $room->signup_start_date = new \DateTime($room->signup_start_date);
        $room->signup_end_date = new \DateTime($room->signup_end_date);

        return view('waitingrooms.edit')->with(compact('room'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(WaitingRoom $room, Request $request)
    {
        $room->delete();

        return redirect()->route('waitingrooms.index')->with('status', 'Waiting Room has been deleted!');
    }
}
