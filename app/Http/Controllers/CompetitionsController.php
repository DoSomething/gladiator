<?php

namespace Gladiator\Http\Controllers;

use Gladiator\Http\Requests\CompetitionRequest;
use Gladiator\Models\Competition;
use Gladiator\Models\Contest;
use Gladiator\Repositories\UserRepositoryContract;
use Gladiator\Services\Manager;
use Illuminate\Http\Request;
use Gladiator\Models\Message;
use Gladiator\Models\User;

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
    public function show(Competition $competition, Request $request)
    {
        $users = $this->manager->createLeaderboard($competition, 10);
        $contest = Contest::find($competition->contest_id);
        $campaign = $this->manager->getCampaign($contest->campaign_id);

        $users = [];
        $ids = $competition->users->pluck('id')->toArray();

        if ($ids) {
            $users = $this->repository->getAll($ids);
        }

        return view('competitions.show', compact('competition', 'contest', 'users', 'campaign'));
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
     * Download the CSV export of all users.
     *
     * @param  \Gladiator\Models\Competition  $competition
     * @return \League\Csv\ $csv
     */
    public function export(Competition $competition)
    {
        $csv = $this->manager->exportCSV($competition, true);
        $csv->output('competition' . $competition->id . '.csv');
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

    public function leaderboard(Competition $competition, Request $request)
    {
        // Determine the amount of users to show in the leaderboard
        $limit = 10;
        $limitQuery = $request->input('limit');

        if (isset($limitQuery)) {
            // If they specified all, get total users
            if ($limitQuery === 'all') {
                $limit = count($competition->users);
            }
            // Otherwise use the given number
            else {
                $limit = (int) $limitQuery;
            }
        }

        // Get the leaderboard
        $users = $this->manager->createLeaderboard($competition, $limit);

        return view('competitions.leaderboard', compact('users'));
    }
}
