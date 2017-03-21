<?php

namespace Gladiator\Http\Controllers\Api;

use Gladiator\Services\Manager;
use Gladiator\Models\Competition;
use Gladiator\Http\Requests\UnsubscribeRequest;

class UnsubscribeController extends ApiController
{
    /**
     * @var Gladiator\Services\Manager;
     */
    protected $manager;

    public function unsubscribe(UnsubscribeRequest $request)
    {
        $credentials = $request->all();

        $competition = Competition::find($credentials['competition_id']);

        // Get competition with activity from flash if it is there.
        // Otherwise, grab it.
        $key = generate_model_flash_session_key($competition, ['includeActivity' => true]);

        if (session()->has($key)) {
            $competition = session($key);
        } else {
            $competition = $this->manager->getCompetitionOverview($competition, true, true);
        }

        $competition->unsubscribeUser($credentials['competition_id'], $credentials['northstar_id']);
    }

    /**
     * Create new UnsubscribeController instance.
     */
    public function __construct(Manager $manager)
    {
        $this->manager = $manager;

        $this->middleware('auth.api');
    }
}
