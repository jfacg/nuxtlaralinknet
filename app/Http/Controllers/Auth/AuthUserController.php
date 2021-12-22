<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthUserController extends Controller
{
    protected $user, $role;

    public function __construct(User $user, Role $role)
    {
        $this->user = $user;
        $this->role = $role;
    }

    public function auth(Request $request)
    {
        $request->validate([
            'email'     => 'required|email',
            'password'  => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid Credentials'], 401);
        }

        $token = $user->createtoken($request->email)->plainTextToken;

        return response()->json(['token' => $token]);
    }

    public function me(Request $request)
    {
        $userAuth = $request->user();

        $user = $this->user->with(['roles', 'roles.permissions', 'empresa'])->find($userAuth->id);
        // $permissions = $this->role->with(['permissions'])->find($user->roles[0]->id);

        return response()->json($user);
    }

    public function logout(Request $request)
    {
        $userAuth = $request->user();
        $userAuth->tokens()->delete();
        return response()->json([], 204);
    }
}
