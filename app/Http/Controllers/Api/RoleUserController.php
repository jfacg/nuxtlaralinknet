<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\{
    Role,
    User
};
use Illuminate\Http\Request;

class RoleUserController extends Controller
{
    protected $user, $role;

    public function __construct(User $user, Role $role)
    {
        $this->user = $user;
        $this->role = $role;
    }

    public function userRoles($idUser)
    {
        $user = $this->user->find($idUser);

        if (!$user) {
            return response()->json(['message' => 'user Not Found'], 404);
        }

        $roles = $user->roles()->paginate();

        return response()->json(['data' => $roles], 200);
    }

    public function rolesAvailable(Request $request, $idUser)
    {
        if (!$user = $this->user->find($idUser)) {
            return response()->json(['message' => 'User Not Found'], 404);
        }

        $filters = $request->except('_token');

        $roles = $user->rolesAvailable($request->filter);

        return response()->json(['data' => $roles, 'filter' => $filters], 200);
    }


    public function attachRolesUser(Request $request, $idUser)
    {
        if (!$user = $this->user->find($idUser)) {
            return response()->json(['message' => 'User Not Found'], 404);
        }

        if (!$request->roles || count($request->roles) == 0) {
            return response()->json(['message' => 'Roles Not Found'], 404);
        }

        $user->roles()->sync($request->roles);
        // $user->roles()->attach($request->roles);

        return response()->json(['message' => 'Roles Inserted'], 200);
    }

    public function detachRoleUser($idUser, $idRole)
    {
        $user = $this->user->find($idUser);
        $role = $this->role->find($idRole);

        if (!$user || !$role) {
            return response()->json(['message' => 'User Not Found or Role Not Found'], 404);
        }

        $user->roles()->detach($role);

        return response()->json(['message' => 'Roles Deleted'], 200);
    }
}
