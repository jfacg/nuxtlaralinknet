<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{

    protected $entity;

    public function __construct (Client $client)
    {
        $this->entity = $client;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = $this->entity->all();
        return response()->json($clients, 200);
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

        $validate = validator($data, $this->entity->rules());
        if ($validate->fails()) {
            $messages = $validate->messages();
            return response()->json($messages, 400);
        }

        $client = $this->entity->create($data);

        if (!$client) {
            return response()->json(['error' => 'error_insert', 500]);
        }

        return response()->json($client, 201);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $client = $this->entity->find($id);

        if (!$client) {
            return response()->json(['message' => 'Client Not Found'], 404);
        }

        return response()->json($client, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();

        $validate = validator($data, $this->entity->rules($id));

        if ($validate->fails()) {
            $messages = $validate->messages();
            return response()->json(['validade.error', $messages], 500);
        }

        $client = $this->entity->find($id);
        if (!$client) {
            return response()->json(['message' => 'Client Not Found'], 404);
        }

        $update = $client->update($data);
        if (!$update) {
            return response()->json(['message' => 'Client Not Update'], 500);
        }

        return response()->json($update, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $client = $this->entity->find($id);
        if (!$client) {
            return response()->json(['message' => 'Client Not Found'], 404);
        }

        $delete =  $client->delete();
        if (!$delete) {
            return response()->json(['message' => 'Client Not Delete'], 500);
        }

        return response()->json($delete, 200);
    }
}
