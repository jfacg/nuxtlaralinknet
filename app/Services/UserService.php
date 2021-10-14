<?php

namespace App\Services;

use App\Repositories\Contracts\UserRepositoryInterface;

class UserService
{
    protected $repository;

    public function __construct (UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getAllUsers()
    {
        return $this->repository->getAllUsers();
    }

    public function createUser(array $data)
    {
        return $this->repository->createUser($data);
    }

    public function getUser(int $id)
    {
        return $this->repository->getUser($id);
    }

    public function updateUser(array $data, int $id)
    {
        return $this->repository->updateUser($data, $id);
    }

    public function deleteUser(int $id)
    {
        return $this->repository->deleteUser($id);
    }

}
