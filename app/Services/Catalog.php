<?php

namespace Gladiator\Services;

class Catalog
{
    /**
     * Build out a catalog list of users sorted by a specified method.
     *
     * @param  \Illuminate\Support\Collection  $users
     * @param  string $sortBy
     * @return array
     */
    public function build($users, $sortBy = 'rank')
    {
        // Return array of collated users grouped as "active" or "inactive".
        $users = $this->collateByReportbackActivity($users);

        foreach ($users['active'] as $user) {
            $user->reportback = $this->tallyReportbackItemStatuses($user->reportback);
        }

        $users['active'] = $this->sort($users['active']);

        return $users;
    }

    /**
     * Sort a list of users by method specified.
     *
     * @param  array  $users
     * @param  string $method
     * @return array
     */
    public function sort($users, $method = 'rank')
    {
        // @TODO: allows adding more sort options in the future, and with session flashed data,
        // would not require additional requests and API calls since all in flash cache.

        if ($method === 'rank') {
            return $this->sortByRank($users);
        }

        if ($method === 'quantity') {
            return $this->sortByReportbackQuantity($users);
        }

        return $users;
    }

    /**
     * Organize and group a collection of users by reportback activity.
     *
     * @param  \Illuminate\Support\Collection  $users
     * @return array
     */
    protected function collateByReportbackActivity($users)
    {
        $active = [];
        $inactive = [];
        $flagged = [];

        foreach ($users as $user) {
            if (! $user->reportback) {
                $inactive[] = $user;
            } elseif ($user->reportback && $user->reportback['flagged']) {
                $flagged[] = $user;
            } else {
                $active[] = $user;
            }
        }

        return [
            'active' => $active,
            'inactive' => $inactive,
            'flagged' => $flagged,
        ];
    }

    /**
     * Sort a list of users by rank.
     *
     * @param  array  $users
     * @return array
     */
    protected function sortByRank($users)
    {
        $users = $this->sortByReportbackQuantity($users);

        $increment = 1;
        $rank = 1;

        foreach ($users as $index => $user) {
            // Don't perform this logic on the first element
            if ($index > 0) {
                // If the last row quantity equals this rows quantity, just increment.
                if ($user->reportback['quantity'] === $users[$index - 1]->reportback['quantity']) {
                    $increment++;
                } else {
                    // Otherwise apply the increment to the rank and reset it back to 1.
                    $rank += $increment;
                    $increment = 1;
                }
            }

            // Give each row a rank
            $users[$index]->rank = $rank;
        }

        return $users;
    }

    /**
     * Remove users with flagged reportbacks from the users array.
     *
     * @param array $users
     * @return array
     */
    protected function removeFlaggedUsers($users)
    {
        return array_values(collect($users)->where('reportback.flagged', false)->toArray());
    }

    /**
     * Get all users with flagged reportbacks.
     *
     * @param array $users
     * @return array
     */
    protected function getFlaggedUsers($users)
    {
        return array_values(collect($users)->where('reportback.flagged', true)->toArray());
    }

    /**
     * Sort a list of users by reportback quantity.
     *
     * @param  array  $users
     * @return array
     */
    protected function sortByReportbackQuantity($users)
    {
        usort($users, function ($a, $b) {
            return $a->reportback['quantity'] <= $b->reportback['quantity'];
        });

        return $users;
    }

    /**
     * Tally up Reportback Item statuses and append to appropriate property on user object.
     *
     * @param  object  $reportback
     * @return object
     */
    protected function tallyReportbackItemStatuses($reportback)
    {
        $statuses = [
            'promoted' => 0,
            'approved' => 0,
            'excluded' => 0,
            'flagged' => 0,
            'pending' => 0,
        ];

        foreach ($reportback['reportback_items']['data'] as $item) {
            $statuses[$item['status']]++;
        }

        $reportback['reportback_items']['count_by_status'] = $statuses;

        return $reportback;
    }
}
