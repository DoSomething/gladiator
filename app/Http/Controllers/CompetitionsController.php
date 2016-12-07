<?php

namespace Gladiator\Http\Controllers;

use Gladiator\Models\User;
use Illuminate\Http\Request;
use Gladiator\Models\Contest;
use Gladiator\Models\Message;
use Gladiator\Services\Manager;
use Gladiator\Models\Competition;
use Gladiator\Models\LeaderboardPhoto;
use Gladiator\Models\FeaturedReportback;
use Gladiator\Http\Requests\CompetitionRequest;
use Gladiator\Repositories\UserRepositoryContract;
use Gladiator\Http\Requests\LeaderboardPhotoRequest;
use Gladiator\Http\Requests\FeaturedReportbackRequest;

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
    public function message(Competition $competition)
    {
        $key = generate_model_flash_session_key($competition, ['includeActivity' => true]);

        if (session()->has($key)) {
            $competition = session($key);

            session()->reflash();
        } else {
            $competition = $this->manager->getCompetitionOverview($competition, true);

            session()->flash($key, $competition);
        }

        $messages = Message::where('contest_id', '=', $competition->contest->id)->where('type', '!=', 'welcome')->get();
        $featuredReportbacks = FeaturedReportback::where('competition_id', '=', $competition->id)->get()->keyBy('message_id');

        return view('messages.show', compact('messages', 'competition', 'featuredReportbacks'));
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

    /**
     * Get the featured reportback form.
     *
     * @param  \Gladiator\Models\Competition  $competition
     * @param  \Gladiator\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function editFeatureReportback(Competition $competition, Message $message)
    {
        $reportback = FeaturedReportback::where('competition_id', '=', $competition->id)->where('message_id', '=', $message->id)->first();

        return view('competitions.featured_reportback.edit', compact('competition', 'message', 'reportback'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Gladiator\Requests\FeaturedReportbackRequest  $request
     * @param  \Gladiator\Models\Competition  $competition
     * @param  \Gladiator\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function updateFeaturedReportback(FeaturedReportbackRequest $request, Competition $competition, Message $message)
    {
        $reportback = FeaturedReportback::where('competition_id', '=', $competition->id)->where('message_id', '=', $message->id)->first();

        // @TODO: Make a function for this, potentially move it out of this controller.
        if (! isset($reportback)) {
            $reportback = new FeaturedReportback;
            $reportback->competition_id = $competition->id;
            $reportback->message_id = $message->id;
            $reportback->save();
        }

        $reportback->fill($request->all())->save();

        return redirect()->route('competitions.message', [$competition, $competition->contest])->with('status', 'Featured reportback has been updated!');
    }

    /**
     * Get the leaderboard photos form.
     *
     * @param  \Gladiator\Models\Competition  $competition
     * @param  \Gladiator\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function editLeaderboardPhotos(Competition $competition, Message $message)
    {
        $key = generate_model_flash_session_key($competition, ['includeActivity' => true]);
        if (session()->has($key)) {
            $competition = session($key);
            session()->reflash();
        } else {
            $competition = $this->manager->getCompetitionOverview($competition, true);
        }

        $leaderboard = $competition->activity['active'];
        $topThree = $this->manager->getTopThreeReportbacks($leaderboard, ['includeUserIds' => true]);

        $photos = [];

        foreach ($topThree as $key => $user) {
            $photos[] = LeaderboardPhoto::where('competition_id', '=', $competition->id)->where('message_id', '=', $message->id)->where('northstar_id', '=', $user['northstar_id'])->first();
        }

        return view('competitions.leaderboard_photos.edit', compact('competition', 'message', 'photos', 'topThree'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Gladiator\Requests\LeaderboardPhotoRequest  $request
     * @param  \Gladiator\Models\Competition  $competition
     * @param  \Gladiator\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function updateLeaderboardPhotos(LeaderboardPhotoRequest $request, Competition $competition, Message $message)
    {
        for ($i = 0; $i <= 2; $i++) {
            // request format: _method, _token, northstar_id_{{$index}},
            //                 reportback_id_{{$index}}, reportback_item_id_{{$index}}
            $userId = $request->input('northstar_id_'.$i);
            $reportbackId = $request->input('reportback_id_'.$i);
            $reportbackItemId = $request->input('reportback_item_id_'.$i);

            // If none of ids null
            if (($userId != 0) && ($reportbackId != 0) && ($reportbackItemId != 0)) {
                $photo = LeaderboardPhoto::where('competition_id', '=', $competition->id)->where('message_id', '=', $message->id)->where('northstar_id', '=', $userId)->first();

                if (! isset($photo)) {
                    $photo = new LeaderboardPhoto;
                    $photo->competition_id = $competition->id;
                    $photo->message_id = $message->id;
                    $photo->northstar_id = $userId;
                }

                $photo->reportback_id = $reportbackId;
                $photo->reportback_item_id = $reportbackItemId;

                $photo->save();
            }
        }

        return redirect()->route('competitions.message', [$competition, $competition->contest])->with('status', 'Leaderboard photos have been updated!');
    }
}
