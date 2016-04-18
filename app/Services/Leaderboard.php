<?php

namespace Gladiator\Services;

class Leaderboard
{
    public function build($users, $sortBy = 'default')
    {
        // Return array of collated users grouped as "active" or "inactive".
        $users = $this->collateByReportbackActivity($users);

        foreach ($users['active'] as $user) {
            $user->reportback = $this->tallyReportbackItemStatuses($user->reportback);
        }

        dd($users['active']);

        // Do more stuff here before ranking...

        if ($sortBy === 'default') {
            return $this->rank($users['active']);
        }

        return $users;
    }

    public function rank($users)
    {
        dd($users);

        return $users;

        // $increment = 1;
        // $rank = 1;

        // foreach ($leaderboard as $index => $row) {
        //     // Don't perform this logic on the first element
        //     if ($index > 0) {
        //         // If the last row quantity equals this rows quantity, just increment.
        //         if ($row['quantity'] === $leaderboard[$index - 1]['quantity']) {
        //             $increment++;
        //         // Otherwise apply the increment to the rank and reset it back to 1.
        //         } else {
        //             $rank += $increment;
        //             $increment = 1;
        //         }
        //     }
        //     // Give each row a rank
        //     $leaderboard[$index]['rank'] = $rank;
        // }

        // return $leaderboard;
    }

    protected function collateByReportbackActivity($users)
    {
        $active = [];
        $inactive = [];

        foreach ($users as $user) {
            if (! $user->reportback) {
                $inactive[] = $user;
            } else {
                $active[] = $user;
            }
        }

        return [
            'active' => $active,
            'inactive' => $inactive,
        ];
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

        foreach ($reportback->reportback_items->data as $item) {
            $statuses[$item->status] ++;
        }

        $reportback->reportback_items->count_by_status = $statuses;

        return $reportback;
    }
}
