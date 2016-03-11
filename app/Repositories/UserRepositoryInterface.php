<?php

namespace Gladiator\Repositories;

interface UserRepositoryInterface
{
    public function find($id);

    public function getAll();

    public function getAllByRole($role);
}
