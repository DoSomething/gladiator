<?php

namespace Gladiator\Services;

use Gladiator\Repositories\UserRepositoryContract;

class ContestManager
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
            $userInfo = $this->repository->find($user->id);
            $details = [$user->id, $userInfo->first_name, $userInfo->last_name, $userInfo->email, $userInfo->mobile];
            if ($reportbacks) {
                //TODO
                array_push($headers, 'some reportback details go here');
            }

            array_push($data, $details);
        }

        return buildCSV($data);
    }
}
