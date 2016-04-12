<?php

namespace Gladiator\Services;

use Carbon\Carbon;
use Gladiator\Models\Contest;
use Gladiator\Services\Northstar\Northstar;
use Gladiator\Repositories\CacheCampaignRepository;
use Gladiator\Repositories\UserRepositoryContract;
use Illuminate\Database\Eloquent\Collection;

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

        $users = $this->userRepository->getAll($users->pluck('id')->all());
        $users = $users->keyBy('id')->all();

        $headers = ['northstar_id', 'first_name', 'last_name', 'email', 'cell'];

        if ($hasReportback) {
            array_push($headers, 'reportback', 'quantity', 'flagged status');
        }

        array_push($data, $headers);

        foreach ($users as $user) {
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
     * Build leaderboard data for a given Competition
     *
     * @param Competition $competition
     * @param User $users
     * @return array $leaderboard
     */
    public function getLeaderboard($competition, $ignoreFlagged = false)
    {
        $rows = [];
        $users = $competition->users;

        // Get all users in bulk
        $ids = $users->pluck('id')->all();
        $users = $this->userRepository->getAll($ids)->keyBy('id')->all();
        $signups = $this->getActivityForAllUsers($ids, $competition);

        foreach ($users as $user) {
            $id = $user->id;
            // For each user get the reportback details
            if (! $signups->has($id)) {
                continue;
            }

            $signup = $signups->get($id);
            if (! isset($signup->reportback)) {
                continue;
            }

            $reportback = $this->formatReportback($signup->reportback);
            $quantity = isset($reportback) ? $reportback->quantity : 0;
            $flagged = isset($reportback) ? $reportback->flagged : 'N/A';

            if ($flagged === 'flagged' && $ignoreFlagged) {
                continue;
            }

            // Give each user a "row" in the leaderboard
            array_push($rows, ['user' => $user, 'quantity' => $quantity, 'flagged' => $flagged]);
        }

        // Sort all of the rows by reportback quantity
        usort($rows, function ($a, $b) {
            return $a['quantity'] <= $b['quantity'];
        });

        // Rank the leaderboard & return
        return $this->rankLeaderboard($rows);
    }

    /**
     * Rank the leaderboard based on traditional :sports: rules.
     * If a group of people tie, they each get the same rank.
     * You then skip to the next rank based on how many people tied.
     * For example, if 3 people tied for second, they each get third.
     * The next person would then get 5th place.
     *
     * @param array $leaderboard
     *  Unranked leaderboard
     * @return array $leaderboard
     *  Ranked leaderboard
     */
    private function rankLeaderboard($leaderboard)
    {
        $increment = 1;
        $rank = 1;

        foreach ($leaderboard as $index => $row) {
            // Don't perform this logic on the first element
            if ($index > 0) {
                // If the last row quantity equals this rows quantity, just increment.
                if ($row['quantity'] === $leaderboard[$index - 1]['quantity']) {
                    $increment++;
                // Otherwise apply the increment to the rank and reset it back to 1.
                } else {
                    $rank += $increment;
                    $increment = 1;
                }
            }
            // Give each row a rank
            $leaderboard[$index]['rank'] = $rank;
        }

        return $leaderboard;
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
     public function getAllUserSignups($ids, $campaign = null, $campaignRun = null)
     {
         $signups = $this->northstar->getUserSignups($ids, $campaign);

         $data = [];

         if ($campaignRun) {
             foreach ($signups as $key => $signup) {
                 if ($signup->campaign_run->id === (string) $campaignRun) {
                     array_push($data, $signups[$key]);
                 }
             }

             if (count(explode(",", $ids)) <= 1) {
                 return array_shift($data);
             }

             return $data;
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

        $signup = $this->getAllUserSignups($id, $campaign, $campaign_run);

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
     *
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
            $signups = array_merge($signups, $this->getAllUserSignups(implode(',', $batch), $campaign, $campaign_run));
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
}
