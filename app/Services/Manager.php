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

        // dd([
        //     'ids' => $ids,
        //     'count' => $count,
        //     'parameters' => $parameters,
        // ]);

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

    protected function appendReportbackToCollection($collection, $parameters)
    {
        // $activity = $this->getActivityForAllUsers($collection->pluck('id')->all(), $parameters);

        // ::: For testing, need to remove :::

        $ids = $collection->pluck('id')->all();

        $curatedIds = [
          // '5639066ba59dbfe6598b4567', // '1705523', // 5639066ba59dbfe6598b4567 & 570fe8f1a59dbf5b048b4569 // Katie Crane
          // '55882c57a59dbfa93d8b4599', // '1700013', // present in actual
          // '560c79dda59dbf9b0a8b456a', // '1705397', // 560afd12a59dbf37038b4569 & 560c79dda59dbf9b0a8b456a
          '559442cca59dbfc9578b4bf4', // '1702694',
          // '56094df7a59dbf57798b4567', // '1705378', // 56094df7a59dbf57798b4567 & 56097d7ea59dbf4c7a8b4568
          '55957df6a59dbfc9578b4c1a', // '1704963',
          '55e60194a59dbfaa118b46ea', // '1705244',
          '55e45e49a59dbfac118b46d6', // '1705239',
          '55ddf0d0a59dbfac118b4647', // '1705226',
          '559442c4a59dbfc9578b4b6a', // '1700226',
          '55d49fe2a59dbfd0618b4653', // '1705162',
          '559a8051a59dbfc9578b4c1e', // '1704964',
          '55c22140a59dbf747b8b4cf7', // '1705086',
          '55bfb463a59dbfca578b5375', // '1705076',
          '55bfca44a59dbf747b8b4ca8', // '1705078',
          '55b78d2ea59dbfca578b5241', // '1705054',
          // '55a53048a59dbf747b8b4923', // '1704994', // 55a53048a59dbf747b8b4923 & 55a52deaa59dbf747b8b491e
          '559442cfa59dbfc9578b4c14', // '10',
          '5571df42a59dbf3b7a8b456d', // '9',
          '55844d19a59dbfa83d8b4592', // '1700083',
          '559442c3a59dbfc9578b4b58', // '1703935',
          '559442c3a59dbfca578b4b68', // '1700230',
          '559442c1a59dbfca578b4b38', // '1703614',
          // '5571f4f5a59dbf3c7a8b4569', // '18', // present in actual
          '559442a9a59dbfc9578b49b0', // '1701495',
          '559442a9a59dbfca578b49af', // '129',
          '559442baa59dbfc9578b4ac4', // '1700233',
        ];

        $ids = array_merge($ids, $curatedIds);  // 58 total, 23 with results

        $activity = $this->getActivityForAllUsers($ids, $parameters);
        // ::: For testing, need to remove :::

        // dd([
        //     'activity' => $activity,
        //     'collection' => $collection,
        // ]);
        // $collection = $collection->merge($activity->all()); // DELETE! ONLY TEMPORARY!

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

    protected function appendReportbackToObject($parameters)
    {
        dd('grab reportback and append to user object');
    }
}

