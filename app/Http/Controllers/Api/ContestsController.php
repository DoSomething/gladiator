<?php

namespace Gladiator\Http\Controllers\Api;

use Carbon\Carbon;
use Gladiator\Http\Transformers\ContestTransformer;
use Gladiator\Http\Transformers\ContestAndWaitingTransformer;
use Gladiator\Models\Contest;
use Gladiator\Models\WaitingRoom;

class ContestsController extends ApiController
{
    /**
     * @var \Gladiator\Http\Transformers\UserTransformer
     */
    protected $transformer;

    protected $contestAndWaitingTransformer;

    /**
     * Create a new ContestsController instance.
     *
     * @param \Gladiator\Http\Transformers\ContestTransformer $transformer
     */
    public function __construct()
    {
        $this->transformer = new ContestTransformer;
        $this->contestAndWaitingTransformer = new ContestAndWaitingTransformer;
    }

    /**
     * Get a collection of contests
     */
    public function index()
    {
        return 'Hello! We need to wait for the Contest CRUD to continue...';
    }

    /**
     * Get a specific contest based on run id.
     *
     * @param int $run_nid
     * @return \Illuminate\Http\Response
     */
    public function getByRunId($run_nid)
    {
        // Get contest by run nid
        $contest = Contest::where('campaign_run_id', $run_nid)->firstOrFail();

        // Get waiting room for this contest
        $waitingRoom = $contest->waitingRoom;

        // Construct a response with all of the data
        $data = [
            'waitingRoom' => $waitingRoom,
            'contest' => $contest,
        ];

        return $this->item($data, 200, [], $this->contestAndWaitingTransformer);
    }
}
