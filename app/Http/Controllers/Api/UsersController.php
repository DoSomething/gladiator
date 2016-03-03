<?php

namespace Gladiator\Http\Controllers\Api;

use Gladiator\Http\Requests\UserRequest;
use Gladiator\Http\Controllers\Controller;
use Gladiator\Repositories\UserRepository;

class UsersController extends Controller
{
    /**
     * [store description]
     * @param  UserRequest $request [description]
     * @return [type]               [description]
     */
    public function store(UserRequest $request)
    {
        // 1. Find if user has account in DS system
        // 2. If Gladiator account continue.
        // 3. If no Gladiator account but NS account, create Gladiator account.
        // 4. Find the specified waiting room by campaign_id && campaign_run_id
        // 5. Assign user to that waiting room


        return 'do the things win the points!';
    }
}
