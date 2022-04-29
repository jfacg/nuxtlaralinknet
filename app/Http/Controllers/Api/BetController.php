<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Bet;
use App\Models\Betdica;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Mockery\Undefined;

class BetController extends Controller
{
    protected $entity, $dicas;

    public function __construct (Bet $bet, Betdica $betdicas)
    {
        $this->entity = $bet;
        $this->dicas = $betdicas;
    }

    public function index()
    {
        $bets = $this->entity->all();

        return response()->json(['data' => $bets], 200);
    }


    public function listar00()
    {
        $bets = $this->entity
                ->where('placar', '=', '0-0')
                ->get();

        return response()->json(['data' => $bets], 200);
    }


    public function dicaseuro00()
    {
        $dicas = [];
        $dicasgreen = [];
        $green = "";

        $bets = $this->entity
                ->where([['placar', '=', '0-0']])
                ->where([['liga', '=', 'EURO']])
                ->get();
        
        
        foreach ($bets as $jogo) {
            $jogoanterior = $this->entity
                ->where([['data', '=', $jogo->data], ['hora', '=', $jogo->hora], ['minuto', '=', $jogo->minuto - 3]])
                ->get();

            $jogoposterior = $this->entity
                ->where([['data', '=', $jogo->data], ['hora', '=', $jogo->hora], ['minuto', '=', $jogo->minuto + 3]])
                ->get();

            $anterior = $this->entity
                ->where([['data', '=', $jogo->data], ['hora', '=', $jogo->hora], ['minuto', '=', $jogo->minuto - 3]])
                ->where([['placar', '!=', "0-0"], ['placar', '!=', "0-1"], ['placar', '!=', "0-2"], ['placar', '!=', "1-0"], ['placar', '!=', "1-1"], ['placar', '!=', "2-0"]])
                ->get();

            $posterior = $this->entity
                ->where([['data', '=', $jogo->data], ['hora', '=', $jogo->hora], ['minuto', '=', $jogo->minuto + 3]])
                ->where([['placar', '!=', "0-0"], ['placar', '!=', "0-1"], ['placar', '!=', "0-2"], ['placar', '!=', "1-0"], ['placar', '!=', "1-1"], ['placar', '!=', "2-0"]])
                ->get();
            

            if ($anterior->count() > 0 && $posterior->count() > 0) {
                array_push($dicas, $jogo);

                if ($jogo->hora == 23) {
                    $dt = Carbon::create($jogo->data)->addDay(1)->format("Y-m-d");
                    $jogo->data = $dt;
                }
                $jogocentro = $this->entity
                    ->where([['data', '=', $jogo->data], ['hora', '=', $jogo->hora + 1], ['minuto', '=', $jogo->minuto]])
                    ->get();

                $jogoesquerda = $this->entity
                    ->where([['data', '=', $jogo->data], ['hora', '=', $jogo->hora + 1], ['minuto', '=', $jogo->minuto - 3]])
                    ->get();

                $jogodireita = $this->entity
                    ->where([['data', '=', $jogo->data], ['hora', '=', $jogo->hora + 1], ['minuto', '=', $jogo->minuto + 3]])
                    ->get();

                $centro = $this->entity
                    ->where([['data', '=', $jogo->data], ['hora', '=', $jogo->hora + 1], ['minuto', '=', $jogo->minuto]])
                    ->where([['placar', '!=', "0-0"], ['placar', '!=', "0-1"], ['placar', '!=', "0-2"], ['placar', '!=', "1-0"], ['placar', '!=', "1-1"], ['placar', '!=', "2-0"]])
                    ->get();

                $esquerda = $this->entity
                    ->where([['data', '=', $jogo->data], ['hora', '=', $jogo->hora + 1], ['minuto', '=', $jogo->minuto - 3]])
                    ->where([['placar', '!=', "0-0"], ['placar', '!=', "0-1"], ['placar', '!=', "0-2"], ['placar', '!=', "1-0"], ['placar', '!=', "1-1"], ['placar', '!=', "2-0"]])
                    ->get();

                $direita = $this->entity
                    ->where([['data', '=', $jogo->data], ['hora', '=', $jogo->hora + 1], ['minuto', '=', $jogo->minuto + 3]])
                    ->where([['placar', '!=', "0-0"], ['placar', '!=', "0-1"], ['placar', '!=', "0-2"], ['placar', '!=', "1-0"], ['placar', '!=', "1-1"], ['placar', '!=', "2-0"]])
                    ->get();

                if ($esquerda->count() > 0 || $centro->count() > 0 || $direita->count() > 0) {
                    array_push($dicasgreen, $jogo);
                
                    if ($esquerda->count() > 0) {
                        $green = $green."1";
                    }
                    
                    if ($centro->count() > 0) {
                        $green = $green."2";
                    }
                    
                    if ($direita->count() > 0) {
                        $green = $green."3";
                    }

                    $dica = [
                        'dicajogoe_id' => $jogoanterior[0]->id, 
                        'dicajogoc_id' => $jogo->id, 
                        'dicajogod_id' => $jogoposterior[0]->id, 
                        'jogoe_id' => $jogocentro[0]->id, 
                        'jogoc_id' => $jogoesquerda[0]->id, 
                        'jogod_id' => $jogodireita[0]->id, 
                        'green' => $green, 
                        'status' => "GREEN", 
                    ];

                    $green = "";

                    $existe = $this->dicas
                        ->where([['dicajogoe_id', '=', $jogoanterior[0]->id], ['dicajogoc_id', '=', $jogo->id], ['dicajogod_id', '=', $jogoposterior[0]->id], ['jogoe_id', '=', $jogocentro[0]->id], ['jogoc_id', '=', $jogoesquerda[0]->id], ['jogod_id', '=', $jogodireita[0]->id]])
                        ->get();
                        
                    if ($existe->count() > 0) {
                        $this->dicas->update($dica);
                    } else {
                        $this->dicas->create($dica);
                    }    
                    
                }
                
            }
        }
        return response()->json(['dicasgreen' => $dicas], 200);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        
        $listaJogos = [];

        foreach ($data as $item) {
            for ($i=1; $i < 21; $i++) { 

                $novo = explode(" ", $item['col'.$i]);
                

                if (sizeof($novo) == 5 ) {
                    $dt = explode("/", $novo[1]);
                    $data = $dt[2]."-".$dt[1]."-".$dt[0];

                    $datanova = Carbon::create($data);
                    // dd($datanova);

                    $jogo = [
                        "liga" => $novo[0],
                        "data" => $datanova,
                        "hora" => $novo[2],
                        "minuto" => $novo[3],
                        "placar" => $novo[4]
                    ];

                    // if (strlen($jogo['placar']) == 3) {
                        
                        $existe = $this->entity
                            ->where([['liga', '=', $jogo['liga']], ['data', '=', $jogo['data']], ['hora', '=', $jogo['hora']]])
                            ->where([['minuto', '=', $jogo['minuto']], ['placar', '=', $jogo['placar']]])
                            ->get();

                        if ($existe->count() > 0) {
                            $this->entity->update($jogo);
                        } else {
                            $this->entity->create($jogo);
                        }  
                    // }

                   
                }
                 
                
                

            }
        }

        return response()->json(['data' => "ok"], 201);
    }

   
    public function show($id)
    {
        if (!$bet = $this->entity->with(['ports', 'ports.clientIxc'])->find($id)) {
            return response()->json(['message' => 'box Not Found'], 404);
        }

        return response()->json(['data' => $bet], 200);
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

        if (!$bet = $this->entity->find($id)) {
            return response()->json(['message' => 'box Not Found'], 404);
        }

        if (!$update = $bet->update($data)) {
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
        if (!$bet = $this->entity->find($id)) {
            return response()->json(['message' => 'box Not Found'], 404);
        }

        if (!$delete =  $bet->delete()) {
            return response()->json(['message' => 'box Not Delete'], 500);
        }

        return response()->json(['data' => $delete], 200);
    }
}
