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
        $user = User::findOrFail($id);

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

    /**
     * Get collection of users by the specified role.
     *
     * @param  string $role
     * @return \Illuminate\Support\Collection
     */
    public function getAllByRole($role)
    {
        $users = User::where('role', '=', $role)->get();

        if ($users->count()) {
            $ids = $users->pluck('id')->toArray();

            $accounts = $this->getBatchedCollection($ids);

            return collect($accounts);
        }

        return $users;
    }

    public function update($request, $id)
    {
        $user = User::findOrFail($id);
        $user->role = $request->role;
        $user->save();

        return $user;
    }

    /**
     * Get large number of users in batches from Northstar.
     *
     * @param  array  $ids
     * @param  int $size
     * @return array
     */
    protected function getBatchedCollection($ids, $size = 50)
    {
        // @TODO: Should this be a function in Northstar Client?
        $count = intval(ceil(count($ids) / 50));
        $index = 0;
        $data = [];

        for ($i = 0; $i < $count; $i++) {
            $batch = array_slice($ids, $index, $size);

            $parameters['limit'] = '50';
            $parameters['filter[_id]'] = implode(',', $batch);

            $accounts = $this->northstar->getAllUsers($parameters);

            $data = array_merge($data, $accounts);

            $index += $size;
        }

        return $data;
    }
}
