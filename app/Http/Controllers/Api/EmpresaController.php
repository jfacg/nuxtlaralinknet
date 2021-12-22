<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Empresa;
use Illuminate\Http\Request;

class EmpresaController extends Controller
{
    protected $entity;

    public function __construct (Empresa $empresa)
    {
        $this->entity = $empresa;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $empresas = $this->entity->all();

        return response()->json(['data' => $empresas], 200);
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
            return response()->json( $messages, 500);
        }

        if (!$empresa = $this->entity->create($data)) {
            return response()->json(['error' => 'error_insert', 500]);
        }

        return response()->json(['data' => $empresa], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!$empresa = $this->entity->find($id)) {
            return response()->json(['message' => 'permission Not Found'], 404);
        }

        return response()->json(['data' => $empresa], 200);
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

        $validate = validator($data, $this->entity->rules($id, 'PUT'));

        if ($validate->fails()) {
            $messages = $validate->messages();
            return response()->json(['validade.error', $messages], 500);
        }

        if (!$empresa = $this->entity->find($id)) {
            return response()->json(['message' => 'permission Not Found'], 404);
        }

        if (!$update = $empresa->update($data)) {
            return response()->json(['message' => 'permission Not Update'], 500);
        }

        return response()->json(['data' => $update], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!$empresa = $this->entity->find($id)) {
            return response()->json(['message' => 'permission Not Found'], 404);
        }

        if (!$delete =  $empresa->delete()) {
            return response()->json(['message' => 'permission Not Delete'], 500);
        }

        return response()->json(['data' => $delete], 200);
    }
}
