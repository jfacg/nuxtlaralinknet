<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pesqinstalacao;
use Illuminate\Http\Request;

class PesqInstalacaoController extends Controller
{
    protected $entity;

    public function __construct (Pesqinstalacao $pesquisa)
    {
        $this->entity = $pesquisa;
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        // $validate = validator($data, $this->entity->rules($id, 'PUT'));
        // if ($validate->fails()) {
        //     $messages = $validate->messages();
        //     return response()->json(['validade.error', $messages], 500);
        // }

        if (!$empresa = $this->entity->find($id)) {
            return response()->json(['message' => 'permission Not Found'], 404);
        }

        if (!$update = $empresa->update($data)) {
            return response()->json(['message' => 'permission Not Update'], 500);
        }

        return response()->json(['data' => $update], 200);
    }
}
