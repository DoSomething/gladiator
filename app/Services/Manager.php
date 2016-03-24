<?php

namespace Gladiator\Services;

use Carbon\Carbon;
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

        return buildCSV($data);
    }

    /**
     * Build a leaderboard for a given Competition
     *
     * @param WaitingRoom|Competition $model
     * @param int $limit Amount of rows in the leaderboard to return
     * @return array $leaderboard
     */
    public function createLeaderboard($competition, $limit = 10)
    {
        $users = $competition->users;
        $rows = [];

        // For each user, combine all of the data into a row
        foreach ($users as $index => $user) {
            // Get user & reportback data
            $user = $this->repository->find($user->id);
            $reportback = $this->getUserActivity($user->id, $competition);

            $quantity = 0;
            $flagged = 'N/A';

            // If the reportback exists, replace the placeholder
            if (isset($reportback)) {
                $quantity = $reportback->quantity;
                $flagged = $reportback->flagged;
            }

            // Push all of the data to a larger array
            array_push($rows, ['user' => $user, 'quantity' => $quantity, 'flagged' => $flagged]);
        }

        // Sort all of the rows based on total quantity
        usort($rows, function ($a, $b) {
            return $a['quantity'] <= $b['quantity'];
        });

        // Now that everything is sorted, only work with the rows we need
        $leaderboard = array_splice($rows, 0, $limit);

        // This is the rank given to the row
        $rank = 1;

        // This is how much the rank is incremented by.
        // In the case of a tie, this will be more than 1.
        $increment = 1;
        foreach ($leaderboard as $index => $row) {
            // Can't compare agaisnt negative index
            if ($index > 0) {

                // If the current quantity equals the previous row's quantity
                if ($row['quantity'] == $leaderboard[$index - 1]['quantity']) {
                    // Increase the increment amount by 1
                    $increment++;
                }
                // Otherwise increase the rank based on the increment & reset
                else {
                    $rank += $increment;
                    $increment = 1;
                }
             }

             // Assign rank to the leaderboard
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
            if (! isset($signup->reportback->flagged)) {
                $signup->reportback->flagged = 'pending';
            } else if ($signup->reportback->flagged) {
                $signup->reportback->flagged = 'flagged';
            } else {
                $signup->reportback->flagged = 'approved';
            }

            // Return the reportback.
            return $signup->reportback;
        }

        // If the user has no activity for this competition or waiting room.
        return null;
    }
}
