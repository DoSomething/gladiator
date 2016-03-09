<?php

namespace Gladiator\Http\Controllers;

use Gladiator\Http\Requests\CompetitionRequest;
use Gladiator\Models\Competition;
use Gladiator\Models\Contest;

class CompetitionsController extends Controller
{
    /**
     * Create new CompetitionsController instance.
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
        $competitions = Competition::all();

        return view('competitions.index', compact('competitions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('competitions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CompetitionRequest $request)
    {
        Competition::create($request->all());

        return redirect()->route('competitions.index')->with('status', 'Competition has been saved!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \Gladiator\Models\Competition  $competition
     * @return \Illuminate\Http\Response
     */
    public function show(Competition $competition)
    {
        $contest = Contest::find($competition->contest_id);

        return view('competitions.show', compact('competition', 'contest'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Gladiator\Models\Competition  $competition
     * @return \Illuminate\Http\Response
     */
    public function edit(Competition $competition)
    {
        return view('competitions.edit', compact('competition'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Gladiator\Models\Competition  $competition
     * @return \Illuminate\Http\Response
     */
    public function update(CompetitionRequest $request, Competition $competition)
    {
        $competition->fill($request->all())->save();

        return redirect()->route('competitions.show', $competition->id)->with('status', 'Competition has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Gladiator\Models\Competition  $competition
     * @return \Illuminate\Http\Response
     */
    public function destroy(Competition $competition)
    {
        $competition->delete();

        return redirect()->route('competitions.index')->with('status', 'Competition has been deleted!');
    }
}
