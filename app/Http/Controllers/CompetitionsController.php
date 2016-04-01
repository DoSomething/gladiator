<?php

namespace Gladiator\Http\Controllers;

use Gladiator\Http\Requests\CompetitionRequest;
use Gladiator\Models\Competition;
use Gladiator\Models\Contest;
use Gladiator\Repositories\UserRepositoryContract;
use Gladiator\Services\Manager;
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
    public function show(Competition $competition)
    {
        $contest = Contest::find($competition->contest_id);

        $users = $this->repository->getAll($competition->users->pluck('id')->toArray());

        return view('competitions.show', compact('competition', 'contest', 'users'));
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
     * Detach a user from a competition.
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
}
