<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Watch;
use Illuminate\Http\Request;

class WatchController extends Controller
{
    protected $entity;

    public function __construct (Watch $watch)
    {
        $this->entity = $watch;
    }

    
    public function index()
    {
        $watchs = $this->entity->with(['empresa', 'usuario'])
                    ->orderBy('email', 'asc')
                    ->get();

        return response()->json(['data' => $watchs], 200);
    }

    
    public function store(Request $request)
    {
        $data = $request->all();

        $validate = validator($data, $this->entity->rules());

        if ($validate->fails()) {
            $messages = $validate->messages();
            return response()->json( $messages, 500);
        }

        if (!$watch = $this->entity->create($data)) {
            return response()->json(['error' => 'error_insert', 500]);
        }

        return response()->json(['data' => $watch], 201);
    }

   
    public function show($id)
    {
        if (!$watch = $this->entity->with(['empresa', 'usuario'])->find($id)) {
            return response()->json(['message' => 'role Not Found'], 404);
        }

        return response()->json(['data' => $watch], 200);
    }


   
    public function update(Request $request, $id)
    {
        $data = $request->all();

        $validate = validator($data, $this->entity->rules($id, 'PUT'));

        if ($validate->fails()) {
            $messages = $validate->messages();
            return response()->json(['validade.error', $messages], 500);
        }

        if (!$watch = $this->entity->find($id)) {
            return response()->json(['message' => 'role Not Found'], 404);
        }

        if (!$update = $watch->update($data)) {
            return response()->json(['message' => 'role Not Update'], 500);
        }

        return response()->json(['data' => $update], 200);
    }

   
    public function destroy($id)
    {
        if (!$watch = $this->entity->find($id)) {
            return response()->json(['message' => 'role Not Found'], 404);
        }

        if (!$delete =  $watch->delete()) {
            return response()->json(['message' => 'role Not Delete'], 500);
        }

        return response()->json(['data' => $delete], 200);
    }
}
