<?php

namespace Gladiator\Services;

use Carbon\Carbon;
use Gladiator\Models\Contest;
use Gladiator\Services\Northstar\Northstar;
use Gladiator\Repositories\CacheCampaignRepository;
use Gladiator\Repositories\UserRepositoryContract;

class Manager
{
    /**
     * CacheCampaignRepository instance.
     *
     * @var \Gladiator\Repositories\CacheCampaignRepository
     */
    protected $campaignRepository;

    /**
     * UserRepositoryContract instance.
     *
     * @var \Gladiator\Repositories\UserRepositoryContract
     */
    protected $userRepository;

    /**
     * Northstar instance.
     *
     * @var \Gladiator\Services\Northstar\Northstar
     */
    protected $northstar;

    /**
     * Create new Registrar instance.
     *
     * @param  $userRepository
     * @param  $campaignRepository
     */
    public function __construct(UserRepositoryContract $userRepository, CacheCampaignRepository $campaignRepository)
    {
        $this->campaignRepository = $campaignRepository;
        $this->userRepository = $userRepository;
        $this->northstar = new Northstar;
    }

    /**
     * Build and export a CSV of user data.
     *
     * @param  object $users
     * @return \League\Csv
     */
    public function exportUsersCsv($users)
    {
        // Similar to above function but no longer need to pass and search for reportbacks if needed.
        // Reportbacks, if exist, already embedded in each user object.

        $data = [];

        // dd($users);

        $data[] = ['northstar_id', 'first_name', 'last_name', 'email', 'mobile number', 'reportback', 'quantity', '# promoted', '# approved', '# excluded', '# flagged', '# pending'];

        foreach ($users as $user) {
            $details = [
                $user->id,
                isset($user->first_name) ? $user->first_name : '',
                isset($user->last_name) ? $user->last_name : '',
                isset($user->email) ? $user->email : '',
                isset($user->mobile) ? $user->mobile : '',
            ];

            $data[] = $details;
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
     * Get a collection of Northstar users that exist on a model.
     *
     * @param  \Gladiator\Models\Competition|WaitingRoom  $model
     * @param  bool  $withReportback
     * @return \Illuminate\Support\Collection  $users
     */
    public function getModelUsers($model, $withReportback = false)
    {
        $users = $model->users;

        if (! $users) {
            return null;
        }

        $ids = $users->pluck('id')->all();

        $users = $this->userRepository->getAll($ids);

        if (! $withReportback) {
            return $users;
        }

        return $this->appendReportback($users);
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

        $signup = $this->northstar->getUserSignups($id, $campaign, $campaign_run);

        if (is_array($signup)) {
            $signup = reset($signup);
        }

        if ($signup && $signup->reportback) {
            return $this->formatReportback($signup->reportback);
        }

        // If the user has no activity for this competition or waiting room.
        return null;
    }

    /**
     * Get reportbacks for many users & a given competition.
     *
     * @param array $ids Array of ID's
     * @param \Gladiator\Models\Competition $competition
     * @param int $batchSize How many reportbacks to fetch at once
     * @return collection $signups
     */
    public function getActivityForAllUsers($ids, $competition, $batchSize = 50)
    {
        $campaign = $competition->contest->campaign_id;
        $campaign_run = $competition->contest->campaign_run_id;

        $signups = [];
        $count = intval(ceil(count($ids) / $batchSize));
        $index = 0;

        for ($i = 0; $i < $count; $i++) {
            $batch = array_slice($ids, $index, $batchSize);
            $signups = array_merge($signups, $this->northstar->getUserSignups(implode(',', $batch), $campaign, $campaign_run, $batchSize));
            $index += $batchSize;
        }

        return collect($signups)->keyBy(function ($item) {
            return $item->user->id;
        });
    }

    /**
     * Formats a given reportback for use in Gladiator.
     *
     * @param object $reportback from API response
     * @return object $reportback
     */
    private function formatReportback($reportback)
    {
        // Provide the admin URL to the reportback.
        $reportback->admin_url = env('PHOENIX_URI') . '/admin/reportback/' . $reportback->id;

        // Format the update timestamp
        $reportback->updated_at = new Carbon($reportback->updated_at);
        $reportback->updated_at = $reportback->updated_at->format('Y-m-d');

        // Set flagged status to 'pending' if it is NULL, otherwise use bool value
        if (! isset($reportback->flagged)) {
            $reportback->flagged = 'pending';
        } elseif ($reportback->flagged) {
            $reportback->flagged = 'flagged';
        } else {
            $reportback->flagged = 'approved';
        }

        // Return the reportback.
        return $reportback;
    }

    /**
     * Append Campaign data to the supplied data if applicable.
     *
     * @param  mixed $data
     * @return mixed
     */
    public function appendCampaign($data)
    {
        if ($data instanceof \Illuminate\Database\Eloquent\Collection) {
            return $this->appendCampaignToCollection($data);
        }

        if ($data instanceof Contest) {
            return $this->appendCampaignToModel($data);
        }

        return null;
    }


    public function appendReportback($data)
    {
        if ($data instanceof \Illuminate\Support\Collection) {
            return $this->appendReportbackToCollection($data);
        }

        if ($data instanceof \stdClass) {
            return $this->appendReportbackToObject($data);
        }

        return null;
    }

    /**
     * Append Campaign data to the supplied collection.
     *
     * @param  \Illuminate\Database\Eloquent\Collection  $collection
     * @return \Illuminate\Database\Eloquent\Collection
     */
    protected function appendCampaignToCollection($collection)
    {
        $campaignIds = $collection->pluck('campaign_id')->all();

        $campaigns = $this->campaignRepository->getAll($campaignIds);

        $campaigns = $campaigns->keyBy('id')->all();

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
        $campaignId = (string) $model->campaign_id;

        $campaign = $this->campaignRepository->find($campaignId);

        // @TODO: RestApiClient is a bit wonky with Phoenix calls and error responses.
        if ($campaign) {
            $model->setAttribute('campaign', $campaign);
        } else {
            $model->setAttribute('campaign', null);
        }

        return $model;
    }

    protected function appendReportbackToCollection($collection)
    {
        dd('grab reportbacks and append to user collection');
    }

    protected function appendReportbackToObject($model)
    {
        dd('grab reportback and append to user object');
    }
}

