<?php

namespace Gladiator\Services;

use Gladiator\Models\Contest;
use Gladiator\Repositories\UserRepositoryContract;
use Gladiator\Services\Northstar\Northstar;

class Manager
{
    /**
     * UserRepositoryContract instance.
     *
     * @var \Gladiator\Repositories\UserRepositoryContract
     */
    protected $repository;

    /**
     * Northstar instance.
     *
     * @var \Gladiator\Services\Northstar\Northstar
     */
    protected $northstar;

    /**
     * Create new Registrar instance.
     *
     * @param Northstar $northstar
     */
    public function __construct(UserRepositoryContract $repository)
    {
        $this->repository = $repository;
        $this->northstar = new Northstar;
    }

    /**
     * Build CSV data for a given WaitingRoom or Competition
     *
     * @param WaitingRoom|Competition $model
     * @param bool $reportbacks Should this csv include reportback data?
     * @return \League\Csv $csv
     */
    public function exportCSV($model, $reportbacks = false)
    {
        $data = [];
        $users = $model->users;

        $headers = ['northstar_id', 'first_name', 'last_name', 'email', 'cell'];

        if ($reportbacks) {
            array_push($headers, 'reportback', 'quantity', 'flagged status');
        }

        array_push($data, $headers);

        foreach ($users as $user) {
            $user = $this->repository->find($user->id);
            $details = [
                $user->id,
                isset($user->first_name) ? $user->first_name : '',
                isset($user->last_name) ? $user->last_name : '',
                isset($user->email) ? $user->email : '',
                isset($user->mobile) ? $user->mobile : '',
            ];

            if ($reportbacks) {
                $userSignup = $this->getUserActivity($user->id, $model);

                if ($userSignup && $userSignup->reportback) {
                    array_push($details,
                        $userSignup->reportback->id,
                        $userSignup->reportback->quantity,
                        ($userSignup->reportback->flagged) ? 'true' : 'false');
                }
            }

            array_push($data, $details);
        }

        return buildCSV($data);
    }

    /**
     * Collect Contest information with Waiting Room and Competitions.
     *
     * @param  string|\Gladiator\Models\Contest $data
     * @return \Gladiator\Models\Contest
     */
    public function collectContestInfo($data)
    {
        if ($data instanceof Contest) {
            $contest = $data->with('waitingRoom.users', 'competitions.users')->firstOrFail();
        } else {
            $contest = Contest::with('waitingRoom.users', 'competitions.users')->findOrFail($data);
        }

        return $contest;
    }

    /**
     * Get user signup for a specific campaign and run. If only user id is
     * provided, the send back all user signups.
     *
     * @param  string $id
     * @param  string $campaign    Campaign ID
     * @param  string $campaignRun Campaign Run ID
     *
     * @return object $signups
     */
    public function getUserSignup($id, $campaign = NULL, $campaignRun = NULL)
    {
        $signups = $this->northstar->getUserSignups($id, $campaign);

        // Only return the sign up record for the run that was specified.
        if ($campaignRun) {
            foreach ($signups as $key => $signup) {
                if ($signup->campaign_run->id == $campaignRun) {
                    $signups = $signups[$key];
                }
            }
        }

        return $signups;
    }

    /**
     * Get a user's signup/reportback activity for a
     * particular competition or waiting room.
     *
     * @param  string $id  User ID
     * @param  \Gladiator\Models\Competition|WaitingRoom $model
     *
     * @return object $signup
     */
    public function getUserActivity($id, $model)
    {
        $campaign = $model->contest->campaign_id;
        $campaign_run = $model->contest->campaign_run_id;

        return $this->getUserSignup($id, $campaign, $campaign_run);
    }
}
