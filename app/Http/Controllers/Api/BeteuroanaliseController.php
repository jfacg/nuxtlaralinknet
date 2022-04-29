<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Beteuro;
use App\Models\Beteuroanalise;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BeteuroanaliseController extends Controller
{

    protected $entity, $euro;

    public function __construct (Beteuroanalise $bet, Beteuro $beteuro)
    {
        $this->entity = $bet;
        $this->euro = $beteuro;
    }

    public function index()
    {
        $bets = $this->entity->with(['dicajogoe', 'dicajogoc','dicajogod','jogoe','jogoc','jogod'])
                    ->get();
        
        $listaBets = [];

        for ($i=0; $i < $bets->count(); $i++) { 
            $jogoe = $bets[$i]->dicajogoe->placar;
            $jogoc = $bets[$i]->dicajogoc->placar;
            $jogod = $bets[$i]->dicajogod->placar;
            $rep = -1;
            
            for ($j=0; $j < $bets->count(); $j++) { 
                if ($jogoe == $bets[$j]->dicajogoe->placar && $jogoc == $bets[$j]->dicajogoc->placar && $jogod == $bets[$j]->dicajogod->placar ) {
                    $rep = $rep + 1;
                }
            }
            $bets[$i]->repetida = $rep;
            array_push($listaBets, $bets[$i]);
        }
            

        return response()->json(['data' => $listaBets], 200);
    }

    public function euroover00()
    {
        $bets = $this->euro
                ->where('placar', '=', '0-0')
                ->orderBy('data', 'asc')
                ->orderBy('hora', 'asc')
                ->orderBy('minuto', 'asc')
                ->get();

        foreach ($bets as $key => $jogo) {
            $jogoe = $this->euro
                ->where([['data', '=', $jogo->data], ['hora', '=', $jogo->hora], ['minuto', '=', $jogo->minuto - 3]])
                ->where([['placar', '!=', "0-0"], ['placar', '!=', "0-1"], ['placar', '!=', "0-2"], ['placar', '!=', "1-0"], ['placar', '!=', "1-1"], ['placar', '!=', "2-0"]])
                ->first();
                
            $jogod = $this->euro
                ->where([['data', '=', $jogo->data], ['hora', '=', $jogo->hora], ['minuto', '=', $jogo->minuto + 3]])
                ->where([['placar', '!=', "0-0"], ['placar', '!=', "0-1"], ['placar', '!=', "0-2"], ['placar', '!=', "1-0"], ['placar', '!=', "1-1"], ['placar', '!=', "2-0"]])
                ->first();
         
            if (!is_null($jogoe) && !is_null($jogod)) {
                
                
                if ($jogo->hora == 23) {
                    $dt = Carbon::create($jogo->data)->addDay(1)->format("Y-m-d");
                    $jogo->data = $dt;
                }
                $jogocentro = $this->euro
                    ->where([['data', '=', $jogo->data], ['hora', '=', $jogo->hora + 1], ['minuto', '=', $jogo->minuto]])
                    ->first();

                $jogoesquerda = $this->euro
                    ->where([['data', '=', $jogo->data], ['hora', '=', $jogo->hora + 1], ['minuto', '=', $jogo->minuto - 3]])
                    ->first();

                $jogodireita = $this->euro
                    ->where([['data', '=', $jogo->data], ['hora', '=', $jogo->hora + 1], ['minuto', '=', $jogo->minuto + 3]])
                    ->first();
            
                $green = "";

                if (!is_null($jogocentro) && !is_null($jogoesquerda) && !is_null($jogodireita)) {

                    if ($this->verificarPlacar($jogoesquerda->placar, "over")) {
                        $green = $green."1";
                    }
                    
                    if ($this->verificarPlacar($jogocentro->placar, 'over')) {
                        $green = $green."2";
                    }
                    
                    if ($this->verificarPlacar($jogodireita->placar, 'over')) {
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
                        'tipo' => 'OVER', 
                        'analise' => '00ISOLADO25', 
                        'status' => ($green == "") ? "RED" : "GREEN"
                    ];

                    $green = "";

                    $existe = $this->entity
                        ->where([['dicajogoe_id', '=', $jogoe->id], ['dicajogoc_id', '=', $jogo->id], 
                        ['dicajogod_id', '=', $jogod->id], ['jogoe_id', '=', $jogoesquerda->id], 
                        ['jogoc_id', '=', $jogocentro->id], ['jogod_id', '=', $jogodireita->id],
                        ['tipo', '=', 'OVER']])
                        ->first();

                    $contnovo = 0;
                    $contatualizado = 0;
                    if (!is_null($existe)) {
                        $this->entity->update($dica);
                        $contatualizado = $contatualizado + 1;
                    } else {
                        $this->entity->create($dica);
                        $contnovo = $contnovo + 1;
                    }   
                }
            }
        }
        return response()->json(['data' => 'novos'.$contnovo.'-'.'atualizados'.$contatualizado], 201); 
    }

    public function euroover20()
    {
        $bets = $this->euro
                ->where('placar', '=', '2-0')
                ->orderBy('data', 'asc')
                ->orderBy('hora', 'asc')
                ->orderBy('minuto', 'asc')
                ->get();

        foreach ($bets as $key => $jogo) {
            $jogos = [];

            $jogoe = $this->euro
                ->where([['data', '=', $jogo->data], ['hora', '=', $jogo->hora], ['minuto', '=', $jogo->minuto - 3]])
                ->where([['placar', '!=', "0-0"], ['placar', '!=', "0-1"], ['placar', '!=', "0-2"], ['placar', '!=', "1-0"], ['placar', '!=', "1-1"], ['placar', '!=', "2-0"]])
                ->first();
                
            $jogod = $this->euro
                ->where([['data', '=', $jogo->data], ['hora', '=', $jogo->hora], ['minuto', '=', $jogo->minuto + 3]])
                ->where([['placar', '!=', "0-0"], ['placar', '!=', "0-1"], ['placar', '!=', "0-2"], ['placar', '!=', "1-0"], ['placar', '!=', "1-1"], ['placar', '!=', "2-0"]])
                ->first();
         
            if (!is_null($jogoe) && !is_null($jogod)) {
                
                if ($jogo->hora == 23) {
                    $dt = Carbon::create($jogo->data)->addDay(1)->format("Y-m-d");
                    $jogo->data = $dt;
                }
                $jogocentro = $this->euro
                    ->where([['data', '=', $jogo->data], ['hora', '=', $jogo->hora + 1], ['minuto', '=', $jogo->minuto]])
                    ->first();

                $jogoesquerda = $this->euro
                    ->where([['data', '=', $jogo->data], ['hora', '=', $jogo->hora + 1], ['minuto', '=', $jogo->minuto - 3]])
                    ->first();

                $jogodireita = $this->euro
                    ->where([['data', '=', $jogo->data], ['hora', '=', $jogo->hora + 1], ['minuto', '=', $jogo->minuto + 3]])
                    ->first();
            
                $green = "";

                if (!is_null($jogocentro) && !is_null($jogoesquerda) && !is_null($jogodireita)) {

                    if ($this->verificarPlacar($jogoesquerda->placar, 'over')) {
                        $green = $green."1";
                    }
                    
                    if ($this->verificarPlacar($jogocentro->placar, 'over')) {
                        $green = $green."2";
                    }
                    
                    if ($this->verificarPlacar($jogodireita->placar, 'over')) {
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
                        'tipo' => 'OVER', 
                        'analise' => '20ISOLADO25', 
                        'status' => ($green == "") ? "RED" : "GREEN"
                    ];

                    $green = "";

                    $existe = $this->entity
                        ->where([['dicajogoe_id', '=', $jogoe->id], ['dicajogoc_id', '=', $jogo->id], 
                        ['dicajogod_id', '=', $jogod->id], ['jogoe_id', '=', $jogoesquerda->id], 
                        ['jogoc_id', '=', $jogocentro->id], ['jogod_id', '=', $jogodireita->id],
                        ['tipo', '=', 'OVER']])
                        ->first();

                    $contnovo = 0;
                    $contatualizado = 0;
                    if (!is_null($existe)) {
                        $this->entity->update($dica);
                        $contatualizado = $contatualizado + 1;
                    } else {
                        $this->entity->create($dica);
                        $contnovo = $contnovo + 1;
                    }    
                }
            }
        }
        return response()->json(['data' => 'jogosanalisados'], 201); 
    }

    public function euroover02()
    {
        $bets = $this->euro
                ->where('placar', '=', '0-2')
                ->orderBy('data', 'asc')
                ->orderBy('hora', 'asc')
                ->orderBy('minuto', 'asc')
                ->get();

        foreach ($bets as $key => $jogo) {
            $jogos = [];

            $jogoe = $this->euro
                ->where([['data', '=', $jogo->data], ['hora', '=', $jogo->hora], ['minuto', '=', $jogo->minuto - 3]])
                ->where([['placar', '!=', "0-0"], ['placar', '!=', "0-1"], ['placar', '!=', "0-2"], ['placar', '!=', "1-0"], ['placar', '!=', "1-1"], ['placar', '!=', "2-0"]])
                ->first();
                
            $jogod = $this->euro
                ->where([['data', '=', $jogo->data], ['hora', '=', $jogo->hora], ['minuto', '=', $jogo->minuto + 3]])
                ->where([['placar', '!=', "0-0"], ['placar', '!=', "0-1"], ['placar', '!=', "0-2"], ['placar', '!=', "1-0"], ['placar', '!=', "1-1"], ['placar', '!=', "2-0"]])
                ->first();
         
            if (!is_null($jogoe) && !is_null($jogod)) {
                
                if ($jogo->hora == 23) {
                    $dt = Carbon::create($jogo->data)->addDay(1)->format("Y-m-d");
                    $jogo->data = $dt;
                }
                $jogocentro = $this->euro
                    ->where([['data', '=', $jogo->data], ['hora', '=', $jogo->hora + 1], ['minuto', '=', $jogo->minuto]])
                    ->first();

                $jogoesquerda = $this->euro
                    ->where([['data', '=', $jogo->data], ['hora', '=', $jogo->hora + 1], ['minuto', '=', $jogo->minuto - 3]])
                    ->first();

                $jogodireita = $this->euro
                    ->where([['data', '=', $jogo->data], ['hora', '=', $jogo->hora + 1], ['minuto', '=', $jogo->minuto + 3]])
                    ->first();
            
                $green = "";

                if (!is_null($jogocentro) && !is_null($jogoesquerda) && !is_null($jogodireita)) {

                    if ($this->verificarPlacar($jogoesquerda->placar, 'over')) {
                        $green = $green."1";
                    }
                    
                    if ($this->verificarPlacar($jogocentro->placar, 'over')) {
                        $green = $green."2";
                    }
                    
                    if ($this->verificarPlacar($jogodireita->placar, 'over')) {
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
                        'tipo' => 'OVER', 
                        'analise' => '20ISOLADO25', 
                        'status' => ($green == "") ? "RED" : "GREEN"
                    ];

                    $green = "";

                    $existe = $this->entity
                        ->where([['dicajogoe_id', '=', $jogoe->id], ['dicajogoc_id', '=', $jogo->id], 
                        ['dicajogod_id', '=', $jogod->id], ['jogoe_id', '=', $jogoesquerda->id], 
                        ['jogoc_id', '=', $jogocentro->id], ['jogod_id', '=', $jogodireita->id],
                        ['tipo', '=', 'OVER']])
                        ->first();

                    $contnovo = 0;
                    $contatualizado = 0;
                    if (!is_null($existe)) {
                        $this->entity->update($dica);
                        $contatualizado = $contatualizado + 1;
                    } else {
                        $this->entity->create($dica);
                        $contnovo = $contnovo + 1;
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

        if ($tipo == 'ambas') {
            foreach ($naoAmbas as $value) {
                if ($placar == $value) {
                    return false;
                }
            }
            return true;
        }
        
        if ($tipo == 'over') {
            foreach ($naoOver as $value) {
                if ($placar == $value) {
                    return false;
                }
            }
            return true;
        }
    }


}
