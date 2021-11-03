<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cobranca;
use App\Models\Historico;
use Illuminate\Http\Request;

class CobrancaController extends Controller
{
    protected $entity;

    public function __construct(Cobranca $cobranca)
    {
        $this->entity = $cobranca;
    } 

    public function index()
    {   
        $cobrancas = $this->entity->with([])->get();
        return response()->json($cobrancas, 200);
    }

    public function store(Request $request)
    {
        $data = $request->all();

        // $validate = validator($data, $this->entity->rules());

        // if ($validate->fails()) {
        //     $messages = $validate->messages();
        //     return response()->json( $messages, 500);
        // }

        if (!$cobranca = $this->entity->create($data)) {
            return response()->json(['error' => 'error_insert', 500]);
        }

        $novaCobranca = $this->entity->with(['usuario'])->find($cobranca->id);

        return response()->json(['data' => $novaCobranca], 201);
    }

    public function boletoixcid($boletoixc_id)
    {
        if (!$cobranca = $this->entity->with(['usuario'])->where('boletoixc_id', $boletoixc_id)->first()) {
            return response()->json(['message' => 'cobranca Not Found'], 404);
        }

        return response()->json(['data' => $cobranca], 200);
    }
}
