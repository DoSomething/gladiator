<?php

namespace Gladiator\Repositories;

interface UserRepositoryContract extends RepositoryContract
{
    /**
     * Create a new user.
     *
     * @param  object  $account
     * @return \Gladiator\Models\User
     */
    public function create($account);

    /**
     * Get collection of users by the specified role.
     *
     * @param  string $role
     * @return \Illuminate\Support\Collection
     */
    public function getAllByRole($role);

    /**
     * Update the specified user's data
     *
     * @param  \Gladiator\Http\Requests\UserRequest $request
     * @param  string $id  Northstar ID
     * @return \Gladiator\Models\User|object
     */
    public function update($request, $id);
}
