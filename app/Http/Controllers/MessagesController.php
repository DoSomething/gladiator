<?php

namespace Gladiator\Http\Controllers;

use Illuminate\Http\Request;
use Gladiator\Models\Contest;
use Gladiator\Models\Competition;
use Gladiator\Models\Message;
use Gladiator\Events\QueueMessageRequest;
use Gladiator\Repositories\MessageRepository;
use Gladiator\Http\Utilities\Email;

class MessagesController extends Controller
{
    /**
     * MessageRepository instance.
     *
     * @var \Gladiator\Repositories\MessageRepository
     */
    protected $repository;

    /**
     * Create new MessagesController instance.
     */
    public function __construct(MessageRepository $repository)
    {
        $this->repository = $repository;

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

        $this->repository->updateMessagesForContest($contest, $request->input('messages'));

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
    public static function sendMessage(Message $message)
    {
        $contestId = request('contest_id');
        $competitionId = request('competition_id');

        $email = new Email();
        $email->message = $message;
        $email->sender = Contest::find($contestId)->sender;
        $email->competition = Competition::find($competitionId);

        //@TODO: only pass one thing in here instead of 3 or more.
        event(new QueueMessageRequest($email));

        return redirect()->route('competitions.message', ['competition' => $competitionId, 'contest' => $contestId])->with('status', 'Fired that right the hell off!');
    }
}
