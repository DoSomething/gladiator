<?php

namespace Gladiator\Services;

use Gladiator\Models\Contest;
use Gladiator\Repositories\UserRepositoryContract;

class Manager
{
    /**
     * UserRepositoryContract instance.
     *
     * @var \Gladiator\Repositories\UserRepositoryContract
     */
    protected $repository;

    /**
     * Create new Registrar instance.
     *
     * @param Northstar $northstar
     */
    public function __construct(UserRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Build CSV data for a given WaitingRoom or Competition
     *
     * @param WaitingRoom|Competition $model
     * @param bool $reportbacks Should this csv include reportback data?
     * @return \League\Csv $csv
     */
    public function exportCSV($model, $reportbacks = false)
    {
        $data = [];
        $users = $model->users;

        $headers = ['northstar_id', 'first_name', 'last_name', 'email', 'cell'];
        if ($reportbacks) {
            //TODO
            array_push($headers, 'some reportback headers go here');
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
            if ($reportbacks) {
                //TODO
                array_push($headers, 'some reportback details go here');
            }

            array_push($data, $details);
        }

        return buildCSV($data);
    }

    /**
     * Collect Contest information with Waiting Room and Competitions.
     *
     * @param  string|\Gladiator\Models\Contest $contest
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

}
