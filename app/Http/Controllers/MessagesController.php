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
use Gladiator\Services\Registrar;

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
     * Registrar instance.
     *
     * @var \Gladiator\Services\Registrar;
     */
    protected $registrar;

    /**
     * Create new MessagesController instance.
     */
    public function __construct(MessageRepository $msgRepository, UserRepositoryContract $userRepository, Manager $manager, Registrar $registrar)
    {
        $this->manager = $manager;
        $this->msgRepository = $msgRepository;
        $this->userRepository = $userRepository;

        $this->middleware('auth');
        $this->middleware('role:admin,staff');

        $this->registrar = $registrar;
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
        $contestId = request('contest_id');
        $competitionId = request('competition_id');
        $competition = Competition::find($competitionId);
        $contest = Contest::find($contestId);
        $contest = $this->manager->appendCampaign($contest);

        // @TODO - Move into it's own function.
        if (request('test')) {
            $user = $this->registrar->findNorthstarAccount('email', $contest->sender_email);

            $users = [$user];
        } else {
            $users = $this->manager->getModelUsers($competition, true);

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
