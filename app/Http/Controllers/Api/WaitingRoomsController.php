<?php

namespace Gladiator\Http\Controllers\Api;

use Illuminate\Http\Request;
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
    public function show(Request $request)
    {
        $this->validate($request, [
            'campaign_id' => 'required|integer'
        ]);

        $campaign_id = $request->input('campaign_id');
        $waiting_room = WaitingRoom::find($campaign_id);

        return response()->json($waiting_room, 201);
    }
}
