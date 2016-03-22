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

        $this->middleware('auth.api');
    }

    /**
     * Get a collection of contests
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $campaignRunId = $request->query('campaign_run_id');

        // @TODO: below is temporary fix until Phoenix GET request updates run_nid param to run_id.
        // We want to aim to not have any proprietary Drupal id names :P
        if (! $campaignRunId) {
            $campaignRunId = $request->query('run_nid');
        }

        if (isset($campaignRunId)) {
            $contest = Contest::with('waitingRoom')->where('campaign_run_id', $campaignRunId)->firstOrFail();

            return $this->item($contest);
        }

        return $this->collection(Contest::all());
    }
}
