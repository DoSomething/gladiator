<?php

namespace Gladiator\Http\Controllers\Api;

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
        $competition = Competition::find($request->input('competition_id'));

        $unsubscribed = $competition->unsubscribe($request->input('northstar_id'));

        if ($unsubscribed) {
            return response()->json(['message' =>'success'], 200, [], JSON_UNESCAPED_SLASHES);
        } else {
            return response()->json(['message' =>'error'], 500, [], JSON_UNESCAPED_SLASHES);
        }
    }
}
