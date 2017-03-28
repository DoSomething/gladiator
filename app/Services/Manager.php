<?php

namespace Gladiator\Services;

use Gladiator\Models\Contest;
use Gladiator\Models\Message;
use Gladiator\Models\LeaderboardPhoto;
use Gladiator\Services\Phoenix\Phoenix;
use Gladiator\Events\QueueMessageRequest;
use Gladiator\Services\Northstar\Northstar;
use Gladiator\Repositories\UserRepositoryContract;
use Gladiator\Repositories\CacheCampaignRepository;

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
     * Phoenix instance.
     *
     * @var \Gladiator\Services\Northstar\Phoenix
     */
    protected $phoenix;

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
        $this->phoenix = new Phoenix;
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

        $data[] = ['Northstar ID', 'First Name', 'Last Name', 'Email', 'Mobile Number', 'Reportback Admin Link', 'Reported Quantity', '# Promoted', '# Approved', '# Excluded', '# Flagged', '# Pending', 'Why Participated', 'Caption for latest Reportback Item', 'Latest Reportback Date', 'Reportback Admin Promoted Link'];

        foreach ($users as $user) {
            $details = [
                $user->id,
                isset($user->first_name) ? $user->first_name : '',
                isset($user->last_name) ? $user->last_name : '',
                isset($user->email) ? $user->email : '',
                isset($user->mobile) ? $user->mobile : '',
            ];

            if (isset($user->reportback)) {
                $details[] = reportback_admin_url($user->reportback->id);
                $details[] = $user->reportback->quantity;
                $details[] = $user->reportback->reportback_items->count_by_status['promoted'];
                $details[] = $user->reportback->reportback_items->count_by_status['approved'];
                $details[] = $user->reportback->reportback_items->count_by_status['excluded'];
                $details[] = $user->reportback->reportback_items->count_by_status['flagged'];
                $details[] = $user->reportback->reportback_items->count_by_status['pending'];
                $details[] = $user->reportback->why_participated;

                $filteredReportbacks = $this->getStatus($user->reportback->reportback_items->data, 'pending');
                $latestReportBackItem = array_pop($user->reportback->reportback_items->data);

                $details[] = $latestReportBackItem->caption;
                $details[] = date('m/d/Y H:i', $latestReportBackItem->created_at);

                if (! is_null($filteredReportbacks)) {
                    $details[] = array_pop($filteredReportbacks)->media->uri;
                }
            }

            $data[] = $details;
        }

        return build_csv($data);
    }

    /**
     * Return array of reportback items with specific status
     *
     *
     * @param array  $data
     * @param string $status
     * @return array
     */
    public function getStatus($data, $status)
    {
        $list = [];

        foreach ($data as $reportbackitem) {
            if ($reportbackitem->status == $status) {
                $list[] = $reportbackitem;
            }
        }

        return $list;
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
    public function getModelUsers($model, $withReportback = false, $subscribed = false)
    {
        $users = ! $subscribed ? $model->users : $model->subscribers;

        if (! $users) {
            return null;
        }

        $ids = $users->pluck('northstar_id')->all();

        $users = $this->userRepository->getAll($ids);

        if (! $withReportback) {
            return $users;
        }

        return $this->appendReportback($users, $this->getCampaignParameters($model));
    }

    /**
     * Get reportbacks for a user & supplied parameters.
     *
     * @param  string  $id
     * @param  array  $parameters
     * @return object
     */
    public function getActivityForUser($id, $parameters = [])
    {
        $parameters['users'] = $id;
        $parameters['count'] = 25;

        // @TODO: Investigat NS proxy; passing a bad ID results in general index of signups response.
        $signup = $this->northstar->getUserSignups($parameters);

        return (object) array_shift($signup['data']);
    }

    /**
     * Get reportbacks for many users & supplied parameters.
     *
     * @param  array  $ids
     * @param  array  $parameters
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

        return collect($signups['data']);
    }

    /**
     * Get the campaign information as parameters for API requests.
     *
     * @param  \Gladiator\Models\Contest|Competition  $model
     * @return array
     */
    public function getCampaignParameters($model)
    {
        $parameters = [];

        if ($model instanceof \Gladiator\Models\Contest) {
            $parameters['campaigns'] = $model->campaign_id;
            $parameters['runs'] = $model->campaign_run_id;
        }

        if ($model instanceof \Gladiator\Models\Competition) {
            if ($model->contest) {
                $parameters['campaigns'] = $model->contest->campaign_id;
                $parameters['runs'] = $model->contest->campaign_run_id;
            }
        }

        return $parameters;
    }

    /**
     * Get the full competition overview and include user activity if specified.
     *
     * @param  \Gladiator\Models\Competition  $competition
     * @param  bool $includeActivity
     * @return \Gladiator\Models\Competition
     */
    public function getCompetitionOverview($competition, $includeActivity = false, $subscribed = false)
    {
        $competition = $competition->load('contest');

        $competition->contest = $this->appendCampaign($competition->contest);

        $competition->contestants = $this->getModelUsers($competition, $includeActivity);

        $competition->subscribers = $this->getModelUsers($competition, $includeActivity, $subscribed);

        if ($includeActivity) {
            $competition->activity = $this->catalogUsers($competition->contestants);

            $key = generate_model_flash_session_key($competition, ['includeActivity' => true]);
        } else {
            $competition->activity = null;

            $key = generate_model_flash_session_key($competition);
        }

        session()->flash($key, $competition);

        return $competition;
    }

    /**
     * Get statistics for the specified competition.
     *
     * @param  \Gladiator\Models\Competition  $competition
     * @return object
     */
    public function getStatisticsForCompetition($competition)
    {
        if (! $competition) {
            return null;
        }

        $statistics = [];

        $statistics['totalContestants'] = count($competition->contestants);
        $statistics['totalReportbacks'] = count($competition->activity['active']);
        $statistics['reportbackRate'] = intval(round(($statistics['totalReportbacks'] / $statistics['totalContestants']) * 100));
        $statistics['impactQuantity'] = 0;

        foreach ($competition->activity['active'] as $user) {
            $statistics['impactQuantity'] += intval($user->reportback['quantity']);
        }

        return (object) $statistics;
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
     * @param  array  $parameters
     * @return mixed
     */
    public function appendReportback($data, $parameters)
    {
        if ($data instanceof \Illuminate\Support\Collection) {
            return $this->appendReportbackToCollection($data, $parameters);
        }

        if ($data instanceof \Gladiator\Models\Competition) {
            return $this->appendReportbackToModel($data, $parameters);
        }

        if ($data instanceof \DoSomething\Gateway\Resources\NorthstarUser) {
            return $this->appendReportbackToUserObject($data, $parameters);
        }

        return null;
    }

    /**
     * Get the top three reportbacks from a given leaderboard.
     * Adds custom info based on options passed in.
     *
     * @param array $leaderboard, array $options
     * @return array $topThree
     */
    public function getTopThreeReportbacks($leaderboard, $options = [])
    {
        $topThreeUsers = array_slice($leaderboard, 0, 3);
        $places = ['1st', '2nd', '3rd'];
        $prizeCopy = ['Taking home the $100 AMEX gift card', 'Winner of the $50 amex gift card', 'Winner of the $25 amex gift card'];

        $topThree = [];

        foreach ($topThreeUsers as $key => $user) {
            // Basic info on top three
            $topThree[] = [
              'place' => $places[$key],
              'first_name' => $user->first_name,
              'prize_copy' => $prizeCopy[$key],
              'quantity' => $user->reportback->quantity,
            ];

            // Provide info on user & reportback ids
            if (isset($options['includeUserIds']) && $options['includeUserIds']) {
                $topThree[$key]['northstar_id'] = $user->northstar_id;
                $topThree[$key]['reportback_id'] = $user->reportback->id;
            }

            // Provide image url/captaion of top three leaderboard images
            if (isset($options['competition_id']) && isset($options['message_id'])) {
                $leaderboardReportbackItem = $this->getLeaderboardPhoto($options['competition_id'], $options['message_id'], $user->northstar_id);   //@NOTE calling Phoenix again

                if (! isset($leaderboardReportbackItem)) {
                    $reportbackItems = $user->reportback->reportback_items->data;
                    $leaderboardReportbackItem = array_pop($reportbackItems);
                }

                $topThree[$key]['image_url'] = $leaderboardReportbackItem->media->uri;
                $topThree[$key]['caption'] = $leaderboardReportbackItem->caption;
            }
        }

        return $topThree;
    }

    /*
     * Determines whether a valid reportback_item _id is present in the LeaderboardPhoto DB
     * for given competition, message, and leaderboard user.
     * Returns the associated reportback item if present.
     *
     * @return  array $reportback_item/null
     */
    public function getLeaderboardPhoto($competitionId, $messageId, $userId)
    {
        if (! isset($competitionId)) {
            return;
        }

        $leaderboardPhoto = LeaderboardPhoto::where('competition_id', '=', $competitionId)->where('message_id', '=', $messageId)->where('user_id', '=', $userId)->first();

        if (isset($leaderboardPhoto) && isset($leaderboardPhoto->reportback_id) && isset($leaderboardPhoto->reportback_item_id)) {
            $reportbackItem = $this->appendReportbackItemToMessage($leaderboardPhoto->reportback_id, $leaderboardPhoto->reportback_item_id);

            if ($reportbackItem) {
                return $reportbackItem;
            }
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
                $contest->setAttribute('campaign', (object) $campaigns[$contest->campaign_id]);
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
        $activity = $this->getActivityForAllUsers($collection->pluck('northstar_id')->all(), $parameters);

        $activity = $activity->keyBy(function ($item) {
            return $item['user']['id'];
        });

        foreach ($collection as $user) {
            if (isset($activity[$user->id])) {
                $user->reportback = $activity[$user->id]['reportback'];
            } else {
                $user->reportback = null;
            }
        }

        return $collection;
    }

    protected function appendReportbackToModel($model, $parameters)
    {
        $userId = $parameters['users'];
        unset($parameters['users']);
        // @TODO: potential refactor; not a fan of the above, but leaving for now.

        $activity = $this->getActivityForUser($userId, $parameters);

        if (isset($activity->reportback)) {
            $model->setAttribute('reportback', (object) $activity->reportback);
        } else {
            $model->setAttribute('reportback', null);
        }

        return $model;
    }

    /**
     * Append Reportback data to the supplied user object.
     *
     * @param  object  $user
     * @param  array  $parameters
     * @return object
     */
    protected function appendReportbackToUserObject($user, $parameters)
    {
        $activity = $this->getActivityForUser($user->id, $parameters);

        if (isset($activity->reportback)) {
            $user->reportback = $activity->reportback;
        } else {
            $user->reportback = null;
        }

        return $user;
    }

    /**
     * Append Reportback item to the message.
     *
     * @param  string  $reportback_id
     * @param  string  $reportback_item_id
     * @return object|null
     */
    public function appendReportbackItemToMessage($reportback_id, $reportback_item_id)
    {
        $reportback = $this->phoenix->getReportback($reportback_id, $reportback_item_id);

        if ($reportback) {
            // Remove the nonsense 0,1,2 array keys and key by the reportback item id.
            $reportback_items = collect($reportback->reportback_items->data)->keyBy('id');

            // Find the matching reportback item, and return the item.
            return $reportback_items->get($reportback_item_id);
        } else {
            return null;
        }
    }

    /**
     * Attach a user object to a waiting room or a competition.
     *
     * @param string $type
     * @param string $id
     * @param object $user
     * @return bool
     */
    public function addUserToModel($model, $id, $user)
    {
        // Attach the user to the room, if it isn't alredy.
        if (! $user->{$model}()->where('id', $id)->first()) {
            $user->{$model}()->attach($id);
        }

        return true;
    }

    /**
     * Fires off an event to send an email a user.
     *
     * @param  Gladiator\Models\User     $user
     * @param  Gladiator\Models\Contest  $contest
     * @param  array $params
     * @return null|void
     */
    public function sendEmail($user, $contest, $params)
    {
        if (! isset($params)) {
            return null;
        }

        $message = Message::where($params)->first();

        if ($message) {
            $resources = [
                'message' => $message,
                'contest' => $contest,
                //@TODO -- fix the Email class so that it doesn't require this property to be sent as an array.
                'users' => [$this->userRepository->find($user->northstar_id)],
                'test' => false,
            ];

            event(new QueueMessageRequest($resources));
        } else {
            return null;
        }
    }

    /**
     * Search for users in Northstar.
     *
     * @param  string $query
     * @param  int $page
     * @return collection|null
     */
    public function search($query, $page = null)
    {
        // Attempt to fetch all users.
        $users = $this->northstar->getAllUsers([
            'search' => [
                '_id' => $query,
                'drupal_id' => $query,
                'email' => $query,
                'mobile' => $query,
            ],
            'page' => is_null($page) ? 1 : $page,
        ]);

        return $users ? collect($users) : null;
    }
}
