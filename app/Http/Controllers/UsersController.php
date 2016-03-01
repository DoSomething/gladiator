<?php

namespace Gladiator\Http\Controllers;

use Gladiator\Models\User;
use Gladiator\Models\WaitingRoom;
use Gladiator\Http\Requests\UserRequest;
use Gladiator\Http\Controllers\Controller;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Gladiator\Http\Requests\UserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $account = User::hasAccountInSystem($request->type, $request->key);
        // dd($account);

        if ($account instanceof User) {
            $user = $account;
        }
        else {
            $user = new User;
            $user->id = $account;
            $user->save();
        }

        if (isset($request->campaign_id) && isset($request->campaign_run_id)) {
            $waitingRoom = WaitingRoom::where('campaign_id', '=', $request->campaign_id)
                                          ->where('campaign_run_id', '=', $request->campaign_run_id)
                                          ->firstOrFail();

            $waitingRoom->users()->attach($user->id);

            return 'user added to specified waiting room';
        }

        return redirect()->back()->with('status', 'User has been added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Gladiator\Http\Requests\UserRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
