<?php

namespace Gladiator\Http\Controllers\Api;

use Gladiator\Models\WaitingRoom;
use Illuminate\Http\Request;

class WaitingRoomsController extends ApiController
{
    public function calculateSplit(Request $request)
    {
        $room = WaitingRoom::find($request->input('waitingRoom'));
        $split = $room->getSplit($request->input('competitionMax'));

        return response()->json($split);
    }
}
