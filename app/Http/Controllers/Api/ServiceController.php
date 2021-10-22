<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{

    protected $entity;

    public function __construct (Service $service)
    {
        $this->entity = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = $this->entity->with(['cliente', 'usuario', 'tecnico', 'vendedor'])->get();
        return response()->json($services, 200);
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

        $service = $this->entity->create($data);

        if (!$service) {
            return response()->json(['error' => 'error_insert', 500]);
        }

        return response()->json($service, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $service = $this->entity->with(['cliente', 'usuario', 'tecnico', 'vendedor'])->find($id);

        if (!$service) {
            return response()->json(['message' => 'Serviço Não Encontrado'], 404);
        }

        return response()->json($service, 200);
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

        $validate = validator($data, $this->entity->rules($id));

        if ($validate->fails()) {
            $messages = $validate->messages();
            return response()->json(['validade.error', $messages], 500);
        }

        $service = $this->entity->find($id);
        if (!$service) {
            return response()->json(['message' => 'Serviço Não Encontrado'], 404);
        }

        $update = $service->update($data);
        if (!$update) {
            return response()->json(['message' => 'Serviço Não Atualizado'], 500);
        }

        return response()->json($update, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $service = $this->entity->find($id);
        if (!$service) {
            return response()->json(['message' => 'Serviço Não Encontrado'], 404);
        }

        $delete =  $service->delete();
        if (!$delete) {
            return response()->json(['message' => 'Serviço Não Excluido'], 500);
        }

        return response()->json($delete, 200);
    }
}
