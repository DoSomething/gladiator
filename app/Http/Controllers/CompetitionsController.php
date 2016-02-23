<?php

namespace Gladiator\Http\Controllers;

use Illuminate\Http\Request;

use Gladiator\Http\Requests;
use Gladiator\Http\Controllers\Controller;
use Gladiator\Models\Competition;

class CompetitionsController extends Controller
{

    private $validation_rules = [
        'campaign_id' => 'required|alpha_num',
        'campaign_run_id' => 'required|alpha_num',
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
        $this->validate($request, $this->validation_rules);
        $input = $request->all();
        Competition::create($input);
        return redirect('/competitions');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $comp = Competition::findOrFail($id);
        return view('competitions.show')->withCompetition($comp);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $comp = Competition::findOrFail($id);
        return view('competitions.edit')->withCompetition($comp);
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
        $this->validate($request, $this->validation_rules);
        $comp = Competition::findOrFail($id);
        $input = $request->all();
        $comp->fill($input)->save();
        return view('competitions.show')->withCompetition($comp);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $comp = Competition::findOrFail($id);
        $comp->delete();
        return redirect('/competitions');
    }
}
