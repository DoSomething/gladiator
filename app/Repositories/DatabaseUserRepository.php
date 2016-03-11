<?php

namespace Gladiator\Repositories;

use Gladiator\Models\User;

class DatabaseUserRepository implements UserRepositoryInterface
{
    public function find($id)
    {
        return User::find($id);
    }

    public function getAll()
    {
        $users = [];

        $users['admins'] = $this->getAllByRole('admin');
        $users['staff'] = $this->getAllByRole('staff');
        $users['contestants'] = $this->getAllByRole(null);

        return $users;
    }

    public function getAllByRole($role)
    {
        return User::where('role', '=', $role)->get();
    }
}
