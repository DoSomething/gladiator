<?php

namespace Gladiator\Http\Controllers\Api;

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
    }

    /**
     * Get a collection of waiting rooms.
     */
    public function index()
    {
        return 'Hello! We need to wait for the Contest CRUD to continue...';
    }
}
