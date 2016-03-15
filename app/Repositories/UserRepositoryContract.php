<?php

namespace Gladiator\Repositories;

interface UserRepositoryContract
{
    /**
     * Create a new user.
     *
     * @param  object  $account
     * @return \Gladiator\Models\User
     */
    public function create($account);

    /**
     * Find the specified resource in the database.
     *
     * @param  string  $id  Northstar ID
     * @return object
     */
    public function find($id);

    /**
     * Get collection of all users or set of users by ids.
     *
     * @param  array $ids Northstar IDs
     * @return \Illuminate\Support\Collection
     */
    public function getAll(array $ids = []);

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
