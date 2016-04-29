<?php

namespace Gladiator\Http\Controllers;

use Illuminate\Http\Request;
use Gladiator\Models\Contest;
use Gladiator\Models\Competition;
use Gladiator\Models\Message;
use Gladiator\Events\QueueMessageRequest;
use Gladiator\Repositories\MessageRepository;
use Gladiator\Repositories\UserRepositoryContract;
use Gladiator\Services\Manager;
use Auth;

class MessagesController extends Controller
{
    /**
     * MessageRepository instance.
     *
     * @var \Gladiator\Repositories\MessageRepository
     */
    protected $msgRepository;

    /**
     * UserRepositoryContract instance.
     *
     * @var \Gladiator\Repositories\UserRepositoryContract
     */
    protected $userRepository;

    /**
     * Create new MessagesController instance.
     */
    public function __construct(MessageRepository $msgRepository, UserRepositoryContract $userRepository, Manager $manager)
    {
        $this->manager = $manager;
        $this->msgRepository = $msgRepository;
        $this->userRepository = $userRepository;

        $this->middleware('auth');
        $this->middleware('role:admin,staff');
    }

    /**
     * Edit the specified resources.
     *
     * @param  string $contestId
     * @return \Illuminate\Http\Response
     */
    public function edit($contestId)
    {
        $contest = Contest::with('messages')->find($contestId);

        return view('contests.messages.edit', compact('contest'));
    }

    /**
     * Update the specified resources.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $contest = Contest::findOrFail($id);

        $this->msgRepository->updateMessagesForContest($contest, $request->input('messages'));

        return redirect()->action('ContestsController@show', $contest->id)->with('status', 'Messages have been updated!');
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $id  Contest ID
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $messages = Message::where('contest_id', '=', $id)->get();

        return view('messages.show', compact('messages'));
    }

    /**
     * Fire an event that queues a message to be sent.
     *
     * @param int $id
     */
    public function sendMessage(Message $message)
    {
        // Get contest.
        $contestId = request('contest_id');
        $contest = Contest::find($contestId);
        $contest = $this->manager->appendCampaign($contest);

        // Get competition with activity.
        $competitionId = request('competition_id');
        $competition = Competition::find($competitionId);

        // Get competition with activity from flash if it is there, otherwise
        // grab it.
        $key = generate_model_flash_session_key($competition, ['includeActivity' => true]);

        if (session()->has($key)) {
            $competition = session($key);
        } else {
            $competition = $this->manager->getCompetitionOverview($competition, $withReportback);
        }

        // Send test emails to authenticated user.
        if (request('test')) {
            $user = Auth::user();
            $user = $this->userRepository->find($user->id);
            $user = $this->manager->appendReportback($user, null);

            $users = [$user];
        } else {
            $users = $competition->contestants;

            // Only send checkin messages to users who haven't reported back.
            if ($message->type === 'checkin') {
                $users = $users->where('reportback', null);
            }
        }

        $resources = [
            'message' => $message,
            'contest' => $contest,
            'competition' => $competition,
            'users' => $users,
            'test' => request('test'),
        ];

        // Kick off email sending
        event(new QueueMessageRequest($resources));

        return redirect()->route('competitions.message', ['competition' => $competitionId, 'contest' => $contestId])->with('status', 'Fired that right the hell off!');
    }
}
