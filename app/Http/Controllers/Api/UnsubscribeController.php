<?php

namespace Gladiator\Http\Controllers\Api;

use DB;
use Gladiator\Models\Competition;
use Gladiator\Http\Requests\UnsubscribeRequest;

class UnsubscribeController extends ApiController
{
    /**
     * Create new UnsubscribeController instance.
     */
    public function __construct()
    {
        $this->middleware('auth.api');
    }

    /**
     * Unsubscribe user from competition.
     *
     * @param  Gladiator\Http\Requests\UnsubscribeRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function unsubscribe(UnsubscribeRequest $request)
    {
        $query = DB::table('competition_user')->where([
            ['northstar_id', '=', $request->input('northstar_id')],
            ['competition_id', '=', $request->input('competition_id')],
        ]);

        if (!$query->first()) {
            return response()->json(['message' => 'There was an error processing that request.'], 500, [], JSON_UNESCAPED_SLASHES);
        } elseif ($query->first()->unsubscribed) {
            return response()->json(['message' => 'User already unsubscribed'], 422, [], JSON_UNESCAPED_SLASHES);
        } else {
            $query->update(['unsubscribed' => 1]);

            return response()->json(['message' => 'success'], 200, [], JSON_UNESCAPED_SLASHES);
        }
    }
}
