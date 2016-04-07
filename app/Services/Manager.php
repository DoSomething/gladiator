<?php

namespace Gladiator\Services;

use Gladiator\Models\Contest;
use Gladiator\Services\Phoenix\Phoenix;
use Gladiator\Services\Northstar\Northstar;
use Gladiator\Repositories\UserRepositoryContract;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

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
     * Phoenix instance.
     *
     * @var \Gladiator\Services\Phoenix\Phoenix
     */
    protected $phoenix;

    /**
     * Create new Registrar instance.
     *
     * @param Northstar $northstar
     */
    public function __construct(UserRepositoryContract $repository)
    {
        $this->repository = $repository;
        $this->northstar = new Northstar;
        $this->phoenix = new Phoenix;
    }

    /**
     * Build CSV data for a given WaitingRoom or Competition
     *
     * @param WaitingRoom|Competition $model
     * @param bool $reportbacks Should this csv include reportback data?
     * @return \League\Csv $csv
     */
    public function exportCSV($model, $hasReportback = false)
    {
        $data = [];
        $users = $model->users;

        $headers = ['northstar_id', 'first_name', 'last_name', 'email', 'cell'];

        if ($hasReportback) {
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

            if ($hasReportback) {
                $reportback = $this->getUserActivity($user->id, $model);

                if ($reportback) {
                    array_push($details,
                        $reportback->admin_url,
                        $reportback->quantity,
                        $reportback->flagged);
                }
            }

            array_push($data, $details);
        }

        return build_csv($data);
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
     * @param  int    $campaignRun Campaign Run ID
     *
     * @return object $signups
     */
    public function getUserSignup($id, $campaign = null, $campaignRun = null)
    {
        $signups = $this->northstar->getUserSignups($id, $campaign);

        // Only return the sign up record for the run that was specified.
        if ($campaignRun) {
            foreach ($signups as $key => $signup) {
                if ($signup->campaign_run->id === (string) $campaignRun) {
                    $signups = $signups[$key];
                }
            }
        }

        return $signups;
    }

    /**
     * Get a user's signup/reportback activity for a
     * competition or waiting room.
     *
     * @param  string $id  User ID
     * @param  \Gladiator\Models\Competition|WaitingRoom $model
     *
     * @return object $reportback
     */
    public function getUserActivity($id, $model)
    {
        $campaign = $model->contest->campaign_id;
        $campaign_run = $model->contest->campaign_run_id;

        $signup = $this->getUserSignup($id, $campaign, $campaign_run);

        if ($signup && $signup->reportback) {
            // Provide the admin URL to the reportback.
            $signup->reportback->admin_url = env('PHOENIX_URI') . '/admin/reportback/' . $signup->reportback->id;

            // Format the update timestamp
            $signup->reportback->updated_at = new Carbon($signup->reportback->updated_at);
            $signup->reportback->updated_at = $signup->reportback->updated_at->format('Y-m-d');

            // Return set flagged status to 'pending' if it is false.
            $signup->reportback->flagged = ($signup->reportback->flagged) ? $signup->reportback->flagged : 'pending';

            // Return the reportback.
            return $signup->reportback;
        }

        // If the user has no activity for this competition or waiting room.
        return null;
    }

    /**
     * Append Campaign data to the supplied data if applicable.
     *
     * @param  mixed $data
     * @return mixed
     */
    public function appendCampaign($data)
    {
        if ($data instanceof Collection) {
            return $this->appendCampaignToCollection($data);
        }

        if ($data instanceof Contest) {
            return $this->appendCampaignToModel($data);
        }

        return;
    }

    /**
     * Append Campaign data to the supplied collection.
     *
     * @param  \Illuminate\Database\Eloquent\Collection  $collection
     * @return \Illuminate\Database\Eloquent\Collection
     */
    protected function appendCampaignToCollection($collection)
    {
        $parameters['ids'] = implode(',', $collection->pluck('campaign_id')->all());

        $campaigns = $this->phoenix->getAllCampaigns($parameters);
        $campaigns = collect($campaigns)->keyBy('id')->all();

        foreach ($collection as $contest) {
            if (isset($campaigns[$contest->campaign_id])) {
                $contest->setAttribute('campaign', $campaigns[$contest->campaign_id]);
            } else {
                $contest->setAttribute('campaign', null);
            }
        }

        return $collection;
    }

    /**
     * Append Campaign data to the supplied model.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return \Illuminate\Database\Eloquent\Model
     */
    protected function appendCampaignToModel($model)
    {
        $campaign = $this->phoenix->getCampaign((string) $model->campaign_id);

        // @TODO: RestApiClient is a bit wonky with Phoenix calls and error responses.
        if ($campaign) {
            $model->setAttribute('campaign', $campaign);
        } else {
            $model->setAttribute('campaign', null);
        }

        return $model;
    }
}
