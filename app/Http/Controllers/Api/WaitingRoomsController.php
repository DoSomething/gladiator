<?php

namespace Gladiator\Http\Controllers\Api;

use Gladiator\Http\Requests\WaitingRoomRequest;
use Gladiator\Http\Controllers\Controller;
use Gladiator\Models\WaitingRoom;

class WaitingRoomsController extends Controller
{
    /**
     * Get a waiting room for the specified campaign ID
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(WaitingRoomRequest $request)
    {
        $waiting_room = WaitingRoom::find($request->input('campaign_id'));

        return response()->json($waiting_room, 200);
    }
}
