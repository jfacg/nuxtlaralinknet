<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\Exceptions\UserNotFoundException;

class UserRepository implements UserRepositoryInterface
{
    protected $entity,
              $paginate = 10;


    public function __construct (User $user)
    {
        $this->entity = $user;
    }


    public function getAllUsers()
    {
        // $users = $this->entity->paginate($this->paginate);
        $users = $this->entity->all();
        return $users;
    }

    public function createUser(array $data)
    {
        $data['password'] = bcrypt($data['password']);
        $user = $this->entity->create($data);
        return $user;
    }

    public function getUser(int $id)
    {
        $user = $this->entity->find($id);
        return $user;
    }

    public function updateUser(array $data, int $id)
    {
        if (!$user = $this->getUser($id)) {
            throw new UserNotFoundException("Usuário não encontrado!", 1);
        }
        return $user->update($data);
    }

    public function deleteUser(int $id)
    {
        if (!$user = $this->getUser($id)) {
            return false;
        }
        $user->delete();
        return true;
    }
}
