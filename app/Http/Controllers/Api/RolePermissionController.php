<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;

class RolePermissionController extends Controller
{
    protected $role, $permission;

    public function __construct(Role $role, Permission $permission)
    {
        $this->role = $role;
        $this->permission = $permission;
    }

    public function rolePermissions($idRole)
    {
        $role = $this->role->find($idRole);

        if (!$role) {
            return response()->json(['message' => 'role Not Found'], 404);
        }

        $permissions = $role->permissions()->get();

        return response()->json(['data' => $permissions], 200);
    }

    public function permissionAvailable(Request $request, $idRole)
    {

        if (!$role = $this->role->find($idRole)) {
            return response()->json(['message' => 'role Not Found'], 404);
        }
        // return response()->json($role);

        $filters = $request->except('_token');

        $permissions = $role->permissionsAvailable($request->filter);

        return response()->json(['data' => $permissions, 'filter' => $filters], 200);
    }


    public function attachPermissionsRole(Request $request, $idrole)
    {
        if (!$role = $this->role->find($idrole)) {
            return response()->json(['message' => 'role Not Found'], 404);
        }

        if (!$request->permissions || count($request->permissions) == 0) {
            return response()->json(['message' => 'permissions Not Found'], 404);
        }

        $role->permissions()->sync($request->permissions);
        // $role->permissions()->attach($request->permissions);

        return response()->json(['message' => 'permissions Inserted'], 200);
    }

    public function detachPermissionRole($idrole, $idpermission)
    {
        $role = $this->role->find($idrole);
        $permission = $this->permission->find($idpermission);

        if (!$role || !$permission) {
            return response()->json(['message' => 'role Not Found or permission Not Found'], 404);
        }

        $role->permissions()->detach($permission);

        return response()->json(['message' => 'permissions Deleted'], 200);
    }
}
