<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Beteuro;
use App\Models\Beteuroanalise;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BeteuroController extends Controller
{
    protected $entity, $betanalise;

    public function __construct (Beteuro $bet, Beteuroanalise $beta)
    {
        $this->entity = $bet;
        $this->betanalise = $beta;
    }

    public function index()
    {
        $bets = $this->entity->all();

        return response()->json(['data' => $bets], 200);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        
        $listaJogos = [];

        foreach ($data as $item) {
            for ($i=1; $i < 21; $i++) { 

                $novo = explode(" ", $item['col'.$i]);

                if (sizeof($novo) == 5 && strcmp($novo[4], '?') != 0 && $novo[0] == "EURO") {
                    $dt = explode("/", $novo[1]);
                    $data = $dt[2]."-".$dt[1]."-".$dt[0];

                    $datanova = Carbon::create($data);

                    $jogo = [
                        "liga" => $novo[0],
                        "data" => $datanova,
                        "hora" => $novo[2],
                        "minuto" => $novo[3],
                        "placar" => trim($novo[4])
                    ];
                        
                    $existe = $this->entity
                        ->where([['liga', '=', $jogo['liga']], ['data', '=', $jogo['data']], ['hora', '=', $jogo['hora']]])
                        ->where([['minuto', '=', $jogo['minuto']], ['placar', '=', $jogo['placar']]])
                        ->get();

                    if ($existe->count() > 0) {
                        $this->entity->update($jogo);
                    } else {
                        $this->entity->create($jogo);
                    }  
                }
            }
        }

        return response()->json(['data' => "ok"], 201);
    }

    public function euroambas00()
    {
        $bets = $this->entity
                ->where('placar', '=', '0-0')
                ->orderBy('data', 'asc')
                ->orderBy('hora', 'asc')
                ->orderBy('minuto', 'asc')
                ->get();

        foreach ($bets as $key => $jogo) {
            $jogos = [];

            $jogoe = $this->entity
                ->where([['data', '=', $jogo->data], ['hora', '=', $jogo->hora], ['minuto', '=', $jogo->minuto - 3]])
                ->where([['placar', '!=', "0-0"], ['placar', '!=', "0-1"], ['placar', '!=', "0-2"], ['placar', '!=', "1-0"], ['placar', '!=', "1-1"], ['placar', '!=', "2-0"]])
                ->first();
                
            $jogod = $this->entity
                ->where([['data', '=', $jogo->data], ['hora', '=', $jogo->hora], ['minuto', '=', $jogo->minuto + 3]])
                ->where([['placar', '!=', "0-0"], ['placar', '!=', "0-1"], ['placar', '!=', "0-2"], ['placar', '!=', "1-0"], ['placar', '!=', "1-1"], ['placar', '!=', "2-0"]])
                ->first();
         
            if (!is_null($jogoe) && !is_null($jogod)) {
                
                if ($jogo->hora == 23) {
                    $dt = Carbon::create($jogo->data)->addDay(1)->format("Y-m-d");
                    $jogo->data = $dt;
                }
                $jogocentro = $this->entity
                    ->where([['data', '=', $jogo->data], ['hora', '=', $jogo->hora + 1], ['minuto', '=', $jogo->minuto]])
                    ->first();

                $jogoesquerda = $this->entity
                    ->where([['data', '=', $jogo->data], ['hora', '=', $jogo->hora + 1], ['minuto', '=', $jogo->minuto - 3]])
                    ->first();

                $jogodireita = $this->entity
                    ->where([['data', '=', $jogo->data], ['hora', '=', $jogo->hora + 1], ['minuto', '=', $jogo->minuto + 3]])
                    ->first();
            
                $green = "";

                if (!is_null($jogocentro) && !is_null($jogoesquerda) && !is_null($jogodireita)) {

                    if ($this->entity->verificarPlacar($jogoesquerda->placar, 'ambas')) {
                        $green = $green."1";
                    }
                    
                    if ($this->entity->verificarPlacar($jogocentro->placar, 'ambas')) {
                        $green = $green."2";
                    }
                    
                    if ($this->entity->verificarPlacar($jogodireita->placar, 'ambas')) {
                        $green = $green."3";
                    }

                    $dica = [
                        'dicajogoe_id' => $jogoe->id, 
                        'dicajogoc_id' => $jogo->id, 
                        'dicajogod_id' => $jogod->id, 
                        'jogoe_id' => $jogoesquerda->id, 
                        'jogoc_id' => $jogocentro->id, 
                        'jogod_id' => $jogodireita->id, 
                        'green' => $green, 
                        'tipo' => 'AMBAS', 
                        'status' => ($green == "") ? "RED" : "GREEN"
                    ];

                    $green = "";

                    $existe = $this->betanalise
                        ->where([['dicajogoe_id', '=', $jogoe->id], ['dicajogoc_id', '=', $jogo->id], ['dicajogod_id', '=', $jogod->id], ['jogoe_id', '=', $jogoesquerda->id], ['jogoc_id', '=', $jogocentro->id], ['jogod_id', '=', $jogodireita->id]])
                        ->first();

                    if (!is_null($existe)) {
                        $this->betanalise->update($dica);
                    } else {
                        $this->betanalise->create($dica);
                    }   
                }
            }
        }
        return response()->json(['data' => 'jogosanalisados'], 201); 
    }

    public function euroambas20()
    {
        $bets = $this->entity
                ->where('placar', '=', '2-0')
                ->orderBy('data', 'asc')
                ->orderBy('hora', 'asc')
                ->orderBy('minuto', 'asc')
                ->get();

        foreach ($bets as $key => $jogo) {
            $jogos = [];

            $jogoe = $this->entity
                ->where([['data', '=', $jogo->data], ['hora', '=', $jogo->hora], ['minuto', '=', $jogo->minuto - 3]])
                ->where([['placar', '!=', "0-0"], ['placar', '!=', "0-1"], ['placar', '!=', "0-2"], ['placar', '!=', "1-0"], ['placar', '!=', "1-1"], ['placar', '!=', "2-0"]])
                ->first();
                
            $jogod = $this->entity
                ->where([['data', '=', $jogo->data], ['hora', '=', $jogo->hora], ['minuto', '=', $jogo->minuto + 3]])
                ->where([['placar', '!=', "0-0"], ['placar', '!=', "0-1"], ['placar', '!=', "0-2"], ['placar', '!=', "1-0"], ['placar', '!=', "1-1"], ['placar', '!=', "2-0"]])
                ->first();
         
            if (!is_null($jogoe) && !is_null($jogod)) {
                
                if ($jogo->hora == 23) {
                    $dt = Carbon::create($jogo->data)->addDay(1)->format("Y-m-d");
                    $jogo->data = $dt;
                }
                $jogocentro = $this->entity
                    ->where([['data', '=', $jogo->data], ['hora', '=', $jogo->hora + 1], ['minuto', '=', $jogo->minuto]])
                    ->first();

                $jogoesquerda = $this->entity
                    ->where([['data', '=', $jogo->data], ['hora', '=', $jogo->hora + 1], ['minuto', '=', $jogo->minuto - 3]])
                    ->first();

                $jogodireita = $this->entity
                    ->where([['data', '=', $jogo->data], ['hora', '=', $jogo->hora + 1], ['minuto', '=', $jogo->minuto + 3]])
                    ->first();
            
                $green = "";

                if (!is_null($jogocentro) && !is_null($jogoesquerda) && !is_null($jogodireita)) {

                    if ($this->entity->verificarPlacar($jogoesquerda->placar, 'ambas')) {
                        $green = $green."1";
                    }
                    
                    if ($this->entity->verificarPlacar($jogocentro->placar, 'ambas')) {
                        $green = $green."2";
                    }
                    
                    if ($this->entity->verificarPlacar($jogodireita->placar, 'ambas')) {
                        $green = $green."3";
                    }

                    $dica = [
                        'dicajogoe_id' => $jogoe->id, 
                        'dicajogoc_id' => $jogo->id, 
                        'dicajogod_id' => $jogod->id, 
                        'jogoe_id' => $jogoesquerda->id, 
                        'jogoc_id' => $jogocentro->id, 
                        'jogod_id' => $jogodireita->id, 
                        'green' => $green, 
                        'tipo' => 'AMBAS', 
                        'analise' => '20ISOLADO25', 
                        'status' => ($green == "") ? "RED" : "GREEN"
                    ];

                    $green = "";

                    $existe = $this->betanalise
                        ->where([['dicajogoe_id', '=', $jogoe->id], ['dicajogoc_id', '=', $jogo->id], ['dicajogod_id', '=', $jogod->id], ['jogoe_id', '=', $jogoesquerda->id], ['jogoc_id', '=', $jogocentro->id], ['jogod_id', '=', $jogodireita->id]])
                        ->first();

                    if (!is_null($existe)) {
                        $this->betanalise->update($dica);
                    } else {
                        $this->betanalise->create($dica);
                    }   
                }
            }
        }
        return response()->json(['data' => 'jogosanalisados'], 201); 
    }

    public function euroambas10()
    {
        $bets = $this->entity
                ->whereOr('placar', '=', '1-0')
                ->whereOr('placar', '=', '0-1')
                ->orderBy('data', 'asc')
                ->orderBy('hora', 'asc')
                ->orderBy('minuto', 'asc')
                ->get();

        foreach ($bets as $key => $jogo) {
            $jogos = [];

            $jogoe = $this->entity
                ->where([['data', '=', $jogo->data], ['hora', '=', $jogo->hora], ['minuto', '=', $jogo->minuto - 3]])
                ->where([['placar', '!=', "0-0"], ['placar', '!=', "0-1"], ['placar', '!=', "0-2"], ['placar', '!=', "1-0"], ['placar', '!=', "1-1"], ['placar', '!=', "2-0"]])
                ->first();
                
            $jogod = $this->entity
                ->where([['data', '=', $jogo->data], ['hora', '=', $jogo->hora], ['minuto', '=', $jogo->minuto + 3]])
                ->where([['placar', '!=', "0-0"], ['placar', '!=', "0-1"], ['placar', '!=', "0-2"], ['placar', '!=', "1-0"], ['placar', '!=', "1-1"], ['placar', '!=', "2-0"]])
                ->first();
         
            if (!is_null($jogoe) && !is_null($jogod)) {
                
                if ($jogo->hora == 23) {
                    $dt = Carbon::create($jogo->data)->addDay(1)->format("Y-m-d");
                    $jogo->data = $dt;
                }
                $jogocentro = $this->entity
                    ->where([['data', '=', $jogo->data], ['hora', '=', $jogo->hora + 1], ['minuto', '=', $jogo->minuto]])
                    ->first();

                $jogoesquerda = $this->entity
                    ->where([['data', '=', $jogo->data], ['hora', '=', $jogo->hora + 1], ['minuto', '=', $jogo->minuto - 3]])
                    ->first();

                $jogodireita = $this->entity
                    ->where([['data', '=', $jogo->data], ['hora', '=', $jogo->hora + 1], ['minuto', '=', $jogo->minuto + 3]])
                    ->first();
            
                $green = "";

                if (!is_null($jogocentro) && !is_null($jogoesquerda) && !is_null($jogodireita)) {

                    if ($this->entity->verificarPlacar($jogoesquerda->placar, 'ambas')) {
                        $green = $green."1";
                    }
                    
                    if ($this->entity->verificarPlacar($jogocentro->placar, 'ambas')) {
                        $green = $green."2";
                    }
                    
                    if ($this->entity->verificarPlacar($jogodireita->placar, 'ambas')) {
                        $green = $green."3";
                    }

                    $dica = [
                        'dicajogoe_id' => $jogoe->id, 
                        'dicajogoc_id' => $jogo->id, 
                        'dicajogod_id' => $jogod->id, 
                        'jogoe_id' => $jogoesquerda->id, 
                        'jogoc_id' => $jogocentro->id, 
                        'jogod_id' => $jogodireita->id, 
                        'green' => $green, 
                        'tipo' => 'AMBAS', 
                        'analise' => '10ISOLADO25', 
                        'status' => ($green == "") ? "RED" : "GREEN"
                    ];

                    $green = "";

                    $existe = $this->betanalise
                        ->where([['dicajogoe_id', '=', $jogoe->id], ['dicajogoc_id', '=', $jogo->id], ['dicajogod_id', '=', $jogod->id], ['jogoe_id', '=', $jogoesquerda->id], ['jogoc_id', '=', $jogocentro->id], ['jogod_id', '=', $jogodireita->id]])
                        ->first();

                    if (!is_null($existe)) {
                        $this->betanalise->update($dica);
                    } else {
                        $this->betanalise->create($dica);
                    }   
                }
            }
        }
        return response()->json(['data' => 'jogosanalisados'], 201); 
    }


    public function verificarPlacar($placar, $tipo)
    {
        $naoAmbas = [   "0-0", "0-1", "0-2", "0-3", "0-4", "0-5", "0-6", 
                        "1-0", "2-0", "3-0", "4-0", "5-0", "6-0"];

        $naoOver = [   "0-0", "0-1", "0-2", "1-0", "1-1", "2-0"];
        $resultado = true;

        if ($tipo == 'ambas') {
            foreach ($naoAmbas as $value) {
                if ($placar == $value) {
                    return false;
                }
            }
            return true;
        }

        
    }

    // public function euro00()
    // {
    //     $dicas = [];
    //     $dicasgreen = [];
    //     $green = "";

    //     $bets = $this->beteuro
    //             ->where([['placar', '=', '0-0']])
    //             ->where([['liga', '=', 'EURO']])
    //             ->get();
        
    //     foreach ($bets as $jogo) {
    //         // $jogoanterior = $this->beteuro
    //         //     ->where([['data', '=', $jogo->data], ['hora', '=', $jogo->hora], ['minuto', '=', $jogo->minuto - 3]])
    //         //     ->first();

    //         // $jogoposterior = $this->beteuro
    //         //     ->where([['data', '=', $jogo->data], ['hora', '=', $jogo->hora], ['minuto', '=', $jogo->minuto + 3]])
    //         //     ->get();

    //         $anterior = $this->beteuro
    //             ->where([['data', '=', $jogo->data], ['hora', '=', $jogo->hora], ['minuto', '=', $jogo->minuto - 3]])
    //             ->where([['placar', '!=', "0-0"], ['placar', '!=', "0-1"], ['placar', '!=', "0-2"], ['placar', '!=', "1-0"], ['placar', '!=', "1-1"], ['placar', '!=', "2-0"]])
    //             ->first();

    //         $posterior = $this->beteuro
    //             ->where([['data', '=', $jogo->data], ['hora', '=', $jogo->hora], ['minuto', '=', $jogo->minuto + 3]])
    //             ->where([['placar', '!=', "0-0"], ['placar', '!=', "0-1"], ['placar', '!=', "0-2"], ['placar', '!=', "1-0"], ['placar', '!=', "1-1"], ['placar', '!=', "2-0"]])
    //             ->first();
            

    //         if ($anterior && $posterior) {
    //             array_push($dicas, $jogo);

    //             if ($jogo->hora == 23) {
    //                 $dt = Carbon::create($jogo->data)->addDay(1)->format("Y-m-d");
    //                 $jogo->data = $dt;
    //             }
    //             $jogocentro = $this->beteuro
    //                 ->where([['data', '=', $jogo->data], ['hora', '=', $jogo->hora + 1], ['minuto', '=', $jogo->minuto]])
    //                 ->get();

    //             $jogoesquerda = $this->beteuro
    //                 ->where([['data', '=', $jogo->data], ['hora', '=', $jogo->hora + 1], ['minuto', '=', $jogo->minuto - 3]])
    //                 ->get();

    //             $jogodireita = $this->beteuro
    //                 ->where([['data', '=', $jogo->data], ['hora', '=', $jogo->hora + 1], ['minuto', '=', $jogo->minuto + 3]])
    //                 ->get();

    //             $centro = $this->beteuro
    //                 ->where([['data', '=', $jogo->data], ['hora', '=', $jogo->hora + 1], ['minuto', '=', $jogo->minuto]])
    //                 ->where([['placar', '!=', "0-0"], ['placar', '!=', "0-1"], ['placar', '!=', "0-2"], ['placar', '!=', "1-0"], ['placar', '!=', "1-1"], ['placar', '!=', "2-0"]])
    //                 ->get();


    //             $esquerda = $this->beteuro
    //                 ->where([['data', '=', $jogo->data], ['hora', '=', $jogo->hora + 1], ['minuto', '=', $jogo->minuto - 3]])
    //                 ->where([['placar', '!=', "0-0"], ['placar', '!=', "0-1"], ['placar', '!=', "0-2"], ['placar', '!=', "1-0"], ['placar', '!=', "1-1"], ['placar', '!=', "2-0"]])
    //                 ->get();


    //             $direita = $this->beteuro
    //                 ->where([['data', '=', $jogo->data], ['hora', '=', $jogo->hora + 1], ['minuto', '=', $jogo->minuto + 3]])
    //                 ->where([['placar', '!=', "0-0"], ['placar', '!=', "0-1"], ['placar', '!=', "0-2"], ['placar', '!=', "1-0"], ['placar', '!=', "1-1"], ['placar', '!=', "2-0"]])
    //                 ->get();
                

    //             if ($esquerda->count() > 0 || $centro->count() > 0 || $direita->count() > 0) {
    //                 array_push($dicasgreen, $jogo);
                
    //                 if ($esquerda->count() == 1) {
    //                     $green = $green."1";
    //                 }
                    
    //                 if ($centro->count() == 1) {
    //                     $green = $green."2";
    //                 }
                    
    //                 if ($direita->count() == 1) {
    //                     $green = $green."3";
    //                 }

    //                 $dica = [
    //                     'dicajogoe_id' => $jogoanterior->id, 
    //                     'dicajogoc_id' => $jogo->id, 
    //                     'dicajogod_id' => $jogoposterior->id, 
    //                     'jogoe_id' => $jogocentro[0]->id, 
    //                     'jogoc_id' => $jogoesquerda[0]->id, 
    //                     'jogod_id' => $jogodireita[0]->id, 
    //                     'green' => $green, 
    //                     'status' => "GREEN", 
    //                 ];

    //                 $green = "";

    //                 $existe = $this->entity
    //                     ->where([['dicajogoe_id', '=', $jogoanterior[0]->id], ['dicajogoc_id', '=', $jogo->id], ['dicajogod_id', '=', $jogoposterior[0]->id], ['jogoe_id', '=', $jogocentro[0]->id], ['jogoc_id', '=', $jogoesquerda[0]->id], ['jogod_id', '=', $jogodireita[0]->id]])
    //                     ->get();
                        
    //                 if ($existe->count() > 0) {
    //                     $this->entity->update($dica);
    //                 } else {
    //                     $this->entity->create($dica);
    //                 }    
                    
    //             } else {
    //                 $dica = [
    //                     'dicajogoe_id' => $jogoanterior[0]->id, 
    //                     'dicajogoc_id' => $jogo->id, 
    //                     'dicajogod_id' => $jogoposterior[0]->id, 
    //                     'jogoe_id' => $jogocentro[0]->id, 
    //                     'jogoc_id' => $jogoesquerda[0]->id, 
    //                     'jogod_id' => $jogodireita[0]->id, 
    //                     'green' => $green, 
    //                     'status' => "RED", 
    //                 ];


    //                 $existe = $this->entity
    //                     ->where([['dicajogoe_id', '=', $jogoanterior[0]->id], ['dicajogoc_id', '=', $jogo->id], ['dicajogod_id', '=', $jogoposterior[0]->id], ['jogoe_id', '=', $jogocentro[0]->id], ['jogoc_id', '=', $jogoesquerda[0]->id], ['jogod_id', '=', $jogodireita[0]->id]])
    //                     ->get();
                        
    //                 if ($existe->count() > 0) {
    //                     $this->entity->update($dica);
    //                 } else {
    //                     $this->entity->create($dica);
    //                 }    
    //             }

    //         }
    //     }
    //     return response()->json(['dicasgreen' => $dicas], 200);
    // }

    

}
