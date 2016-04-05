<?php

namespace Gladiator\Http\Controllers;

use Illuminate\Http\Request;
use Gladiator\Models\Contest;
use Gladiator\Models\Competition;
use Gladiator\Models\Message;
use Gladiator\Events\QueueMessageRequest;
use Gladiator\Repositories\MessageRepository;
use Gladiator\Repositories\UserRepositoryContract;
use Gladiator\Http\Utilities\Email;

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
    public function __construct(MessageRepository $msgRepository, UserRepositoryContract $userRepository)
    {
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
        // @TODO - is there a better way of bringing in this repository to this class?
        $userRepository = app(\Gladiator\Repositories\UserRepositoryContract::class);

        $contestId = request('contest_id');
        $competitionId = request('competition_id');
        $competition = Competition::find($competitionId);
        $contest = Contest::find($contestId);

        // @TODO - move this user logic into some sorta helper, we do it a lot.
        $users = [];
        $ids = $competition->users->pluck('id')->toArray();

        if ($ids) {
            $users = $userRepository->getAll($ids);
        }

        // Build the email.
        $email = new Email($message, $contest, $competition, $users);

        // Kick off email sending
        event(new QueueMessageRequest($email));

        return redirect()->route('competitions.message', ['competition' => $competitionId, 'contest' => $contestId])->with('status', 'Fired that right the hell off!');
    }
}
