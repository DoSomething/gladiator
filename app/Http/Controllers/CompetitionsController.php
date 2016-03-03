<?php

namespace Gladiator\Http\Controllers;

use Gladiator\Http\Requests\CompetitionRequest;
use DB;
use Gladiator\Models\Competition;
use Gladiator\Models\User;
use Gladiator\Services\Northstar\Exceptions\NorthstarUserNotFoundException;

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

        return redirect()->route('competitions.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \Gladiator\Models\Competition  $competition
     * @return \Illuminate\Http\Response
     */
    public function show(Competition $competition)
    {
        //@TODO - Move this to function in the Model?
        $competitionUsers = DB::table('competition_user')->where('competition_id', $competition->id)->get();
        $phoenix = app('phoenix');

        foreach ($competitionUsers as $key => $user) {
            try {
                $competitionUsers[$key] = User::hasNorthstarAccount('_id', $user->user_id);
            }
            catch (NorthstarUserNotFoundException $e) {
                //@TODO - do something here.
            }
        }

        foreach ($competitionUsers as $user) {
            if ($user) {
                $phoenix->getUserSignupData($user->drupal_id, $competition->campaign_id);
            }
        }
        return view('competitions.show', compact('competition', 'competitionUsers'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Gladiator\Models\Competition  $competition
     * @return \Illuminate\Http\Response
     */
    public function edit(Competition $competition)
    {
        // Convert the dates to Date objects so we can use them as default values.
        $competition->start_date = new \DateTime($competition->start_date);
        $competition->end_date = new \DateTime($competition->end_date);

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
        $this->validate($request, $this->$validationRules);

        $competition->fill($request->all())->save();

        return view('competitions.show')->withCompetition($competition);
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

        return redirect()->route('competitions.index');
    }
}
