<?php

namespace Gladiator\Http\Controllers\Api;

use Gladiator\Models\WaitingRoom;
use Gladiator\Http\Requests\WaitingRoomRequest;
use Gladiator\Http\Transformers\WaitingRoomTransformer;

class WaitingRoomsController extends ApiController
{
    /**
     * @var \Gladiator\Http\Transformers\UserTransformer
     */
    protected $transformer;

    /**
     * Create a new WaitingRoomsController instance.
     */
    public function __construct(WaitingRoomTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    /**
     * Get a collection of waiting rooms.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(WaitingRoomRequest $request)
    {
        // @TODO: see if there's a better way to handle URL params in Laravel.
        $campaignId = $request->input('campaign_id');

        if (isset($campaignId)) {
            $waitingRooms = WaitingRoom::where('campaign_id', '=', $request->input('campaign_id'))->get();
        } else {
            $waitingRooms = WaitingRoom::all();
        }

        return $this->collection($waitingRooms);
    }
}
