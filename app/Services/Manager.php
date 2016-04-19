<?php

namespace Gladiator\Services;

use Gladiator\Models\Contest;
use Gladiator\Repositories\CacheCampaignRepository;
use Gladiator\Repositories\UserRepositoryContract;
use Gladiator\Services\Northstar\Northstar;

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
        $data = [];

        $data[] = ['northstar_id', 'first_name', 'last_name', 'email', 'mobile number', 'reportback', 'quantity', '# promoted', '# approved', '# excluded', '# flagged', '# pending'];

        foreach ($users as $user) {
            $details = [
                $user->id,
                isset($user->first_name) ? $user->first_name : '',
                isset($user->last_name) ? $user->last_name : '',
                isset($user->email) ? $user->email : '',
                isset($user->mobile) ? $user->mobile : '',
            ];

            if (isset($user->reportback)) {
                $details[] = env('PHOENIX_URI') . '/admin/reportback/' . $user->reportback->id;
                $details[] = $user->reportback->quantity;
                $details[] = $user->reportback->reportback_items->count_by_status['promoted'];
                $details[] = $user->reportback->reportback_items->count_by_status['approved'];
                $details[] = $user->reportback->reportback_items->count_by_status['excluded'];
                $details[] = $user->reportback->reportback_items->count_by_status['flagged'];
                $details[] = $user->reportback->reportback_items->count_by_status['pending'];
            }

            $data[] = $details;
        }

        return build_csv($data);
    }

    /**
     * Catalog a list of users and sort by a specified method.
     *
     * @param  array  $users
     * @param  string $sortBy
     * @return array
     */
    public function catalogUsers($users, $sortBy = 'rank')
    {
        $catalog = new Catalog;

        return $catalog->build($users, $sortBy);
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

        return $this->appendReportback($users, $model);
    }

    /**
     * Get a user's signup/reportback activity for a
     * competition or waiting room.
     *
     * @param  string $id  User ID
     * @param  \Gladiator\Models\Competition|WaitingRoom $model
     * @return object $reportback
     */
    public function getActivityForUser($id, $model)
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
     * @param  array  $ids
     * @param  \Gladiator\Models\Competition  $competition
     * @param  int  $batchSize
     * @return \Illuminate\Support\Collection $signups
     */
    public function getActivityForAllUsers($ids, $parameters = [], $batchSize = 50)
    {
        $count = intval(ceil(count($ids) / $batchSize));
        $index = 0;
        $signups = [];

        for ($i = 0; $i < $count; $i++) {
            $batch = array_slice($ids, $index, $batchSize);

            $parameters['users'] = implode(',', $batch);
            $parameters['count'] = $batchSize;

            $signups = array_merge($signups, $this->northstar->getAllUserSignups($parameters));

            $index += $batchSize;
        }

        return collect($signups);
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

    /**
     * Append Reportback data to the supplied data if applicable.
     *
     * @param  mixed  $data
     * @param  \Gladiator\Models\Competition  $model
     * @return mixed
     */
    public function appendReportback($data, $model)
    {
        $parameters = [];

        if ($model->contest) {
            $parameters['campaigns'] = $model->contest->campaign_id;
            $parameters['runs'] = $model->contest->campaign_run_id;
        }

        if ($data instanceof \Illuminate\Support\Collection) {
            return $this->appendReportbackToCollection($data, $parameters);
        }

        if ($data instanceof \stdClass) {
            return $this->appendReportbackToObject($data, $parameters);
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

    /**
     * Append Reportback data to the supplied collection of users.
     *
     * @param  \Illuminate\Support\Collection  $collection
     * @param  array  $parameters
     * @return \Illuminate\Support\Collection
     */
    protected function appendReportbackToCollection($collection, $parameters)
    {
        $activity = $this->getActivityForAllUsers($collection->pluck('id')->all(), $parameters);

        $activity = $activity->keyBy(function ($item) {
            return $item->user->id;
        });

        foreach ($collection as $user) {
            if (isset($activity[$user->id])) {
                $user->reportback = $activity[$user->id]->reportback;
            } else {
                $user->reportback = null;
            }
        }

        return $collection;
    }

    /**
     * Append Reportback data to the supplied user object.
     *
     * @param  object  $object
     * @param  array  $parameters
     * @return object
     */
    protected function appendReportbackToObject($object, $parameters)
    {
        // @TODO: not used at the moment, but will be @_@
        // grab reportback and append to user object

        return null;
    }
}
