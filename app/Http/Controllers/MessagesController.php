<?php

namespace Gladiator\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Gladiator\Models\Contest;
use Gladiator\Models\Message;
use Gladiator\Services\Manager;
use Gladiator\Models\Competition;
use Gladiator\Events\QueueMessageRequest;
use Gladiator\Repositories\MessageRepository;
use Gladiator\Repositories\UserRepositoryContract;

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
        // Get competition with activity.
        $competitionId = request('competition_id');

        $contest = Contest::find(request('contest_id'));
        $contest = $this->manager->appendCampaign($contest);

        if ($competitionId) {
            $competition = Competition::find($competitionId);

            // Get competition with activity from flash if it is there.
            // Otherwise, grab it.
            $key = generate_model_flash_session_key($competition, ['includeActivity' => true]);

            if (session()->has($key)) {
                $competition = session($key);
            } else {
                $competition = $this->manager->getCompetitionOverview($competition, true, true);
            }
        }

        // Send test emails to authenticated user.
        if (request('test')) {
            $user = Auth::user();
            $user = $this->userRepository->find($user->northstar_id);
            $user = $this->manager->appendReportback($user, []);

            $users = [$user];
        } else {
            //Send messages to those who are subscribed
            $users = $competition->subscribers;

            // Only send checkin messages to users who haven't reported back.
            if ($message->type === 'checkin') {
                $users = $competition->activity['inactive'];
            }
        }

        $resources = [
            'message' => $message,
            'competition' => isset($competition) ? $competition : null,
            'contest' => $contest,
            'users' => $users,
            'test' => request('test'),
        ];

        // Kick off email sending
        event(new QueueMessageRequest($resources));

        if (! $competitionId) {
            return redirect()->back()->with('status', 'Fired that right the hell off!');
        }

        return redirect()->route('competitions.message', ['competition' => $competitionId, 'contest' => request('contest_id')])->with('status', 'Fired that right the hell off!');
    }
}
