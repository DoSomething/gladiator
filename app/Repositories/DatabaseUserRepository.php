<?php

namespace Gladiator\Repositories;

use Gladiator\Models\User;
use DoSomething\Gateway\Northstar;

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
    public function __construct(Northstar $northstar)
    {
        $this->northstar = $northstar;
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
        $user->northstar_id = $account->id;
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

        $account = $this->northstar->getUser('id', $user->northstar_id);

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
        // @TODO: returns collection of users without the role property, but should it be included?
        if ($ids) {
            $accounts = $this->getBatchedCollection($ids);

            return $accounts;
        }

        $accounts = $this->getBatchedCollection(User::all()->pluck('northstar_id')->all());

        return $accounts;
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
            $users = $users->keyBy('northstar_id');
            $ids = array_keys($users->all());

            $accounts = $this->getBatchedCollection($ids);

            foreach ($accounts as $account) {
                $account = $this->appendRole($account, $users[$account->id]->role);
            }

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
     * Append the user's role to the account object from Northstar.
     *
     * @param  object $account
     * @param  string $role
     * @return object
     */
    protected function appendRole($account, $role)
    {
        return $account->role = $role;
    }

    /**
     * Get large number of users in batches from Northstar.
     *
     * @param  array  $ids
     * @param  int $size
     * @return \Illuminate\Support\Collection
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
            $data = array_merge($data, $accounts->toArray());

            $index += $size;
        }

        return collect($data);
    }
}
