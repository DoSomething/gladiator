<?php

namespace Gladiator\Http\Controllers;

use Gladiator\Models\Contest;
use Gladiator\Http\Requests\ContestRequest;
use Gladiator\Http\Requests;

class ContestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contests = Contest::all();

        return view('contest.index', compact('contests'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('contest.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContestRequest $request)
    {
        Contest::create($request->all());

        return redirect()->back()->with('status', 'Contest has been saved!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \Gladiator\Models\Competition  $competition
     * @return \Illuminate\Http\Response
     */
    public function show(Contest $contest)
    {
        return view('contest.show', compact('contest'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Gladiator\Models\WaitingRoom  $room
     * @return \Illuminate\Http\Response
     */
    public function edit(Contest $contest)
    {
        return view('contest.edit', compact('contest'));
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
        $contest->fill($request->all())->save();

        return redirect()->back()->with('status', 'Contest has been updated!');
    }
}
