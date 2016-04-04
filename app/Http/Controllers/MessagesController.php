<?php

namespace Gladiator\Http\Controllers;

use Illuminate\Http\Request;
use Gladiator\Models\Contest;
use Gladiator\Models\Competition;
use Gladiator\Models\Message;
use Gladiator\Events\QueueMessageRequest;
use Gladiator\Repositories\MessageRepository;
use Gladiator\Http\Utilities\Email;
use Gladiator\Repositories\UserRepositoryContract;

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
        $email->contest = Contest::find($contestId);
        $email->competition = Competition::find($competitionId);

        //@TODO: open new user repository and get all users with info
        // when i used $this, it doesn't work, i think b/c this is a static function.
        // $users = $this->repository2->getAll($email->competition->users->pluck('id')->toArray());

        // Foreach user, send the email.
        // I think it makes sense to have users be passed in on their own, since you have
        // to send to each one, but feel free to change this if it doesn't make sense.
        // foreach ($email->competition->users as $user) {
        //     event(new QueueMessageRequest($email, $user));
        // }

        return redirect()->route('competitions.message', ['competition' => $competitionId, 'contest' => $contestId])->with('status', 'Fired that right the hell off!');
    }
}
