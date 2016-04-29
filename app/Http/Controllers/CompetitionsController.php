<?php

namespace Gladiator\Http\Controllers;

use Gladiator\Models\User;
use Gladiator\Models\Contest;
use Gladiator\Models\Message;
use Gladiator\Services\Manager;
use Gladiator\Models\Competition;
use Gladiator\Http\Requests\CompetitionRequest;
use Gladiator\Repositories\UserRepositoryContract;
use Illuminate\Http\Request;

class CompetitionsController extends Controller
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
     * Create new CompetitionsController instance.
     */
    public function __construct(UserRepositoryContract $repository, Manager $manager)
    {
        $this->repository = $repository;
        $this->manager = $manager;

        $this->middleware('auth');
        $this->middleware('role:admin,staff');
    }

    /**
     * Display the specified resource.
     *
     * @param  \Gladiator\Models\Competition  $competition
     * @return \Illuminate\Http\Response
     */
    public function show(Competition $competition)
    {
        $key = generate_model_flash_session_key($competition, ['includeActivity' => true]);

        if (session()->has($key)) {
            $competition = session($key);

            session()->reflash();
        } else {
            $competition = $this->manager->getCompetitionOverview($competition, true);
        }

        $statistics = $this->manager->getStatisticsForCompetition($competition);

        return view('competitions.show', compact('competition', 'statistics'));
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

    /**
     * Download a CSV export of all users based on different criteria.
     *
     * @param  \Gladiator\Models\Competition  $competition
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function export(Competition $competition, Request $request)
    {
        $fileName = 'contest_' . $competition->contest_id . '-' . 'competition_' . $competition->id;

        $withReportback = convert_string_to_boolean($request->input('withReportback'));

        if (! $withReportback) {
            $fileName = $fileName . '-users';

            $key = generate_model_flash_session_key($competition);
        } else {
            $fileName = $fileName . '-leaderboard';

            $key = generate_model_flash_session_key($competition, ['includeActivity' => true]);
        }

        if (session()->has($key)) {
            $competition = session($key);
        } else {
            $competition = $this->manager->getCompetitionOverview($competition, $withReportback);
        }

        if (! $withReportback) {
            $users = $competition->contestants;
        } else {
            $users = $competition->activity['active'];
        }

        $csv = $this->manager->exportUsersCsv($users);

        $csv->output($fileName . '.csv');
    }

    /**
     * Detach a user from a competition.
     *
     * @param  \Gladiator\Models\Competition  $competition
     * @param  \Gladiator\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function removeUser(Competition $competition, User $user)
    {
        $user->competitions()->detach($competition->id);

        return redirect()->back()->with('status', 'User was removed from competition ' . $competition->id);
    }

    /**
     * Show and send messages in a competition.
     *
     * @param  \Gladiator\Models\Competition  $competition
     * @param  \Gladiator\Models\Contest  $contest
     * @return \Illuminate\Http\Response
     */
    public function message(Competition $competition, Contest $contest)
    {
        $messages = Message::where('contest_id', '=', $contest->id)->get();

        return view('messages.show', compact('messages', 'competition'));
    }

    /**
     * Display the specified leaderboard.
     *
     * @param  \Gladiator\Models\Competition  $competition
     * @return \Illuminate\Http\Response
     */
    public function leaderboard(Competition $competition)
    {
        $key = generate_model_flash_session_key($competition, ['includeActivity' => true]);

        if (session()->has($key)) {
            $competition = session($key);

            session()->reflash();
        } else {
            $competition = $this->manager->getCompetitionOverview($competition, true);

            session()->flash($key, $competition);
        }

        $flagged = $competition->activity['flagged'];
        $leaderboard = $competition->activity['active'];
        $pending = $competition->activity['inactive'];

        return view('competitions.leaderboard', compact('competition', 'leaderboard', 'pending', 'flagged'));
    }
}
