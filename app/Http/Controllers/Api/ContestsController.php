<?php

namespace Gladiator\Http\Controllers\Api;

use Illuminate\Http\Request;
use Gladiator\Models\Contest;
use Gladiator\Models\WaitingRoom;
use Gladiator\Http\Transformers\ContestTransformer;

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
        $query = $this->newQuery(Contest::class)->with(['waitingRoom', 'competitions', 'messages']);
        $filters = $request->query('filter');
        $query = $this->filter($query, $filters, Contest::$indexes);

        return $this->paginatedCollection($query, $request);
    }
}
