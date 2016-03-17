<?php

namespace Gladiator\Http\Controllers\Api;

use Gladiator\Http\Transformers\ContestTransformer;
use Gladiator\Models\Contest;
use Gladiator\Models\WaitingRoom;
use Illuminate\Http\Request;

class ContestsController extends ApiController
{
    /**
     * @var \Gladiator\Http\Transformers\UserTransformer
     */
    protected $transformer;

    /**
     * Create a new ContestsController instance.
     *
     * @param \Gladiator\Http\Transformers\ContestTransformer $transformer
     */
    public function __construct()
    {
        $this->transformer = new ContestTransformer;
    }

    /**
     * Get a collection of contests
     */
    public function index(Request $request)
    {
        $campaign_run_nid = $request->query('run_nid');
        if (isset($campaign_run_nid)) {
            $contest = Contest::with('waitingRoom')->where('campaign_run_id', $campaign_run_nid)->firstOrFail();

            return $this->item($contest);
        }

        return $this->collection(Contest::all());
    }
}
