<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Box;
use App\Models\Ocupacao;
use Illuminate\Http\Request;

class BoxController extends Controller
{
    protected $entity;

    public function __construct (Box $box)
    {
        $this->entity = $box;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $boxes = $this->entity->all();

        return response()->json(['data' => $boxes], 200);
    }

    public function ocupacao()
    {
        $caixas = [];
        
        $boxes = $this->entity
                    ->with(['ports'])
                    ->where('status', '=', 'ATIVA')
                    ->get();
        

        foreach ($boxes as $box) {
            $caixa = (object)[
                'id' => '',
                'caixa' => '',
                'portaAtiva' => 0,
                'portaOcupada' => 0,
                'portaCancelada' => 0,
                'portaUtilizada' => 0,
                'portas' => 0,
                'ocupacao' => 0,
                'endereco' => '',
                'sinal' => '',
                
            ];
           
            foreach ($box->ports as $port) {
                if ($port->status ===  "ATIVA") {
                    ++$caixa->portaAtiva;
                    ++$caixa->portaUtilizada;
                }
                if ($port->status ===  "OCUPADA") {
                    ++$caixa->portaOcupada;
                    ++$caixa->portaUtilizada;
                }
                if ($port->status ===  "CANCELADO") {
                    ++$caixa->portaCancelada;
                    ++$caixa->portaUtilizada;
                }
            }

            $caixa->id = $box->id;
            $caixa->caixa = $box->name;
            $caixa->portas = $box->numberPorts;
            $caixa->endereco = $box->address;
            $caixa->sinal = $box->signal;
            $caixa->ocupacao = ($caixa->portaUtilizada / $caixa->portas ) * 100;


            array_push($caixas, $caixa);
        }


        return response()->json(['data' => $caixas, 'teste' => $boxes], 200);
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

        if (!$box = $this->entity->create($data)) {
            return response()->json(['error' => 'error_insert', 500]);
        }

        return response()->json(['data' => $box], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!$box = $this->entity->with(['ports', 'ports.clientIxc'])->find($id)) {
            return response()->json(['message' => 'box Not Found'], 404);
        }

        return response()->json(['data' => $box], 200);
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

        // return response()->json($data, 404);

        $validate = validator($data, $this->entity->rules($id));

        if ($validate->fails()) {
            $messages = $validate->messages();
            return response()->json(['validade.error', $messages], 500);
        }

        if (!$box = $this->entity->find($id)) {
            return response()->json(['message' => 'box Not Found'], 404);
        }

        if (!$update = $box->update($data)) {
            return response()->json(['message' => 'box Not Update'], 500);
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
        if (!$box = $this->entity->find($id)) {
            return response()->json(['message' => 'box Not Found'], 404);
        }

        if (!$delete =  $box->delete()) {
            return response()->json(['message' => 'box Not Delete'], 500);
        }

        return response()->json(['data' => $delete], 200);
    }
}
