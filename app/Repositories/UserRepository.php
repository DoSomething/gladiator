<?php

class UserRepository
{
    // @TODO: Do the thing win the points. Shared User business logic goes here!

    // From UsersController
    // send to custom assignWaitingRoom() method?
    // if (isset($request->campaign_id) && isset($request->campaign_run_id)) {
    //     $waitingRoom = WaitingRoom::where('campaign_id', '=', $request->campaign_id)
    //                                   ->where('campaign_run_id', '=', $request->campaign_run_id)
    //                                   ->firstOrFail();

    //     $waitingRoom->users()->attach($user->id);

    //     return 'user added to specified waiting room';
    // }
}
