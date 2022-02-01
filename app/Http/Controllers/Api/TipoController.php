<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tipo;
use Illuminate\Http\Request;

class TipoController extends Controller
{
    public function __construct (Tipo $tipo)
    {
        $this->entity = $tipo;
    }

    public function index()
    {
        $tipos = $this->entity->all();

        return response()->json(['data' => $tipos], 200);
    }

   
    public function store(Request $request)
    {
        $data = $request->all();

        $validate = validator($data, $this->entity->rules());

        if ($validate->fails()) {
            $messages = $validate->messages();
            return response()->json( $messages, 500);
        }

        if (!$tipo = $this->entity->create($data)) {
            return response()->json(['error' => 'error_insert', 500]);
        }

        return response()->json(['data' => $tipo], 201);
    }

   
    public function show($id)
    {
        if (!$tipo = $this->entity->find($id)) {
            return response()->json(['message' => 'permission Not Found'], 404);
        }

        return response()->json(['data' => $tipo], 200);
    }

    public function listarPorClasse($classe)
    {
        if (!$tipo = $this->entity->where('tipoClasse', '=', $classe)->get()) {
            return response()->json(['message' => 'permission Not Found'], 404);
        }

        return response()->json(['data' => $tipo], 200);
    }


    public function update(Request $request, $id)
    {
        $data = $request->all();

        $validate = validator($data, $this->entity->rules($id, 'PUT'));

        if ($validate->fails()) {
            $messages = $validate->messages();
            return response()->json(['validade.error', $messages], 500);
        }

        if (!$tipo = $this->entity->find($id)) {
            return response()->json(['message' => 'permission Not Found'], 404);
        }

        if (!$update = $tipo->update($data)) {
            return response()->json(['message' => 'permission Not Update'], 500);
        }

        return response()->json(['data' => $update], 200);
    }

 
    public function destroy($id)
    {
        if (!$tipo = $this->entity->find($id)) {
            return response()->json(['message' => 'permission Not Found'], 404);
        }

        if (!$delete =  $tipo->delete()) {
            return response()->json(['message' => 'permission Not Delete'], 500);
        }

        return response()->json(['data' => $delete], 200);
    }
}
