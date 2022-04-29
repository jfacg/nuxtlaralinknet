<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Maquina;
use Illuminate\Http\Request;

class MaquinaController extends Controller
{
    protected $maquina;

    public function __construct (Maquina $maquina)
    {
        $this->maquina = $maquina;
    }

    public function index()
    {
        $maquinas = $this->maquina->all();

        return response()->json(['data' => $maquinas], 200);
    }

   
    public function store(Request $request)
    {
        $data = $request->all();

        $validate = validator($data, $this->maquina->rules());

        if ($validate->fails()) {
            $messages = $validate->messages();
            return response()->json( $messages, 500);
        }

        if (!$maquina = $this->maquina->create($data)) {
            return response()->json(['error' => 'error_insert', 500]);
        }

        return response()->json(['data' => $maquina], 201);
    }

   
    public function show($id)
    {
        if (!$maquina = $this->maquina->find($id)) {
            return response()->json(['message' => 'permission Not Found'], 404);
        }

        return response()->json(['data' => $maquina], 200);
    }

    public function listarPorClasse($classe)
    {
        if (!$maquina = $this->maquina->where('maquinaClasse', '=', $classe)->get()) {
            return response()->json(['message' => 'permission Not Found'], 404);
        }

        return response()->json(['data' => $maquina], 200);
    }


    public function update(Request $request, $id)
    {
        $data = $request->all();

        $validate = validator($data, $this->maquina->rules($id, 'PUT'));

        if ($validate->fails()) {
            $messages = $validate->messages();
            return response()->json(['validade.error', $messages], 500);
        }

        if (!$maquina = $this->maquina->find($id)) {
            return response()->json(['message' => 'permission Not Found'], 404);
        }

        if (!$update = $maquina->update($data)) {
            return response()->json(['message' => 'permission Not Update'], 500);
        }

        return response()->json(['data' => $update], 200);
    }

 
    public function destroy($id)
    {
        if (!$maquina = $this->maquina->find($id)) {
            return response()->json(['message' => 'permission Not Found'], 404);
        }

        if (!$delete =  $maquina->delete()) {
            return response()->json(['message' => 'permission Not Delete'], 500);
        }

        return response()->json(['data' => $delete], 200);
    }
}
