<?php

namespace Gladiator\Repositories;

use Gladiator\Models\User;
use Gladiator\Services\Northstar\Northstar;

class DatabaseUserRepository implements UserRepositoryInterface
{
    protected $northstar;

    public function __construct()
    {
        $this->northstar = new Northstar;
    }

    /**
     * Find the specified resource in the database.
     *
     * @param  string  $id  Northstar ID
     * @return object
     */
    public function find($id)
    {
        $user = User::find($id);

        $account = $this->northstar->getUser('_id', $user->id);

        if ($account) {
            $account->role = $user->role;
            return $account;
        }

        return $user;
    }

    public function getAll()
    {
        // $users = [];
        // $users['admins'] = $this->getAllByRole('admin');
        // $users['staff'] = $this->getAllByRole('staff');
        // $users['contestants'] = $this->getAllByRole(null);

        // dd($users);

        // return $users;
    }

    public function getAllByRole($role)
    {
        $users = User::where('role', '=', $role)->get();
        $ids = implode(',', $users->pluck('id')->toArray());

        $filters = ['_id' => $ids];

        $this->northstar->getUsers(null, null, $filters);

        dd($users);
        dd($ids);
    }

    public function getIdsByRole($role)
    {
        // $users = $this->getAllByRole()
        dd('ready to pluck');
    }
}
