<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateUser;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class UserController extends Controller
{
    protected $entity;

    public function __construct (User $user)
    {
        $this->entity = $user;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = $this->entity->with(['roles', 'empresa'])->get();

        return response()->json($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $nickname = explode(" ", $data['name'])[0];
        $data['nick_name'] = $nickname;

        $validate = validator($data, $this->entity->rules());

        if ($validate->fails()) {
            $messages = $validate->messages();
            return response()->json( $messages, 500);
        }

        $data['password'] = bcrypt($data['password']);

        if (!$user = $this->entity->create($data)) {
            return response()->json(['error' => 'error_insert', 500]);
        }

        return response()->json(['data' => $user]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!$user = $this->entity->with(['roles', 'empresa'])->find($id)) {
            return response()->json(['message' => 'User Not Found'], 404);
        }

        return response()->json(['data' => $user]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();

        $nickname = explode(" ", $data['name'])[0];
        $data['nick_name'] = $nickname;

        $validate = validator($data, $this->entity->rules($id, 'PUT'));

        if ($validate->fails()) {
            $messages = $validate->messages();
            return response()->json( $messages, 500);
        }

        if (Arr::exists($data, 'password')) {
            $data['password'] = bcrypt($data['password']);
        }

        if (!$user = $this->entity->find($id)) {
            return response()->json(['message' => 'User Not Found'], 404);
        }

        if (!$update = $user->update($data)) {
            return response()->json(['message' => 'User Not Update'], 500);
        }

        // return response()->json(['data' => $data]);
        return response()->json(['data' => $update]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!$user = $this->entity->find($id)) {
            return response()->json(['message' => 'User Not Found'], 404);
        }

        if (!$delete =  $user->delete()) {
            return response()->json(['message' => 'User Not Delete'], 500);
        }

        return response()->json(['data' => $delete]);
    }
}
