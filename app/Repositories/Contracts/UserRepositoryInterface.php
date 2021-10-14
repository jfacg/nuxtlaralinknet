<?php

namespace App\Repositories\Contracts;

use App\Models\User;

interface UserRepositoryInterface
{
    public function getAllUsers();
    public function createUser(array $data);
    public function getUser(int $id);
    public function updateUser(array $data, int $id);
    public function deleteUser(int $id);

}
