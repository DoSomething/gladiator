<?php

namespace Gladiator\Repositories;

use Gladiator\Models\User;
use Gladiator\Services\Northstar\Northstar;

class DatabaseUserRepository implements UserRepositoryContract
{
    /**
     * Northstar instance.
     *
     * @var \Gladiator\Services\Northstar\Northstar
     */
    protected $northstar;

    /**
     * Create new DatabaseUserRepository instance.
     */
    public function __construct()
    {
        $this->northstar = new Northstar;
    }

    /**
     * Create a new user.
     *
     * @param  object  $account
     * @return \Gladiator\Models\User
     */
    public function create($account)
    {
        $user = new User;
        $user->id = $account->id;
        $user->role = isset($account->role) ? $account->role : null;
        $user->save();

        return $user;
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

    /**
     * Get collection of all users or set of users by ids.
     *
     * @param  array $ids Northstar IDs
     * @return \Illuminate\Support\Collection
     */
    public function getAll(array $ids = [])
    {
        if ($ids) {
            $accounts = $this->getBatchedCollection($ids);

            return collect($accounts);
        }

        $accounts = $this->getBatchedCollection(User::all()->pluck('id')->all());

        return collect($accounts);
    }

    /**
     * Get collection of users by the specified role.
     *
     * @param  string $role
     * @return \Illuminate\Support\Collection
     */
    public function getAllByRole($role = null)
    {
        $users = User::where('role', '=', $role)->get();

        if ($users->count()) {
            $ids = $users->pluck('id')->toArray();

            $accounts = $this->getBatchedCollection($ids);

            return collect($accounts);
        }

        return $users;
    }

    /**
     * Update the specified user's data
     *
     * @param  \Gladiator\Http\Requests\UserRequest $request
     * @param  string $id  Northstar ID
     * @return \Gladiator\Models\User
     */
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
