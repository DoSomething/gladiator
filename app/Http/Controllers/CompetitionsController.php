<?php

namespace Gladiator\Http\Controllers;

use Illuminate\Http\Request;
use Gladiator\Models\Competition;

class CompetitionsController extends Controller
{

    private $validationRules = [
        'campaign_id' => 'required|numeric',
        'campaign_run_id' => 'required|numeric',
        'start_date' => 'required|date',
        'end_date' => 'required|date',
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $competitions = Competition::all();
        return view('competitions.index')->withCompetitions($competitions);
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
    public function store(Request $request)
    {
        $this->validate($request, $this->$validationRules);
        Competition::create($request->all());
        return redirect()->route('competitions.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $competition = Competition::findOrFail($id);
        return view('competitions.show')->withCompetition($competition);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $competition = Competition::findOrFail($id);
        return view('competitions.edit')->withCompetition($competition);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, $this->$validationRules);
        $competition = Competition::findOrFail($id);
        $competition->fill($request->all())->save();
        return view('competitions.show')->withCompetition($competition);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $competition = Competition::findOrFail($id);
        $competition->delete();
        return redirect()->route('competitions.index');
    }
}
