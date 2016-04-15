<?php

namespace Gladiator\Services;

class Leaderboard
{
    public function build($users, $sortBy = 'default')
    {
        if ($sortBy === 'default') {
            return $this->rank($users);
        }

        return $users;
    }

    public function rank($users)
    {

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
}
