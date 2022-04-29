<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Betdica;
use Illuminate\Http\Request;

class BetdicaController extends Controller
{
    protected $entity;

    public function __construct (Betdica $betdica)
    {
        $this->entity = $betdica;
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

    public function store(Request $request)
    {
        $data = $request->all();
        
        $listaJogos = [];

        foreach ($data as $item) {
            for ($i=1; $i < 21; $i++) { 
                $novo = explode(" ", $item['col'.$i]); 
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
                
                if (!$bet = $this->entity->create($jogo)) {
                    return response()->json(['error' => 'error_insert', 500]);
                }

            }
        }

        return response()->json(['data' => "ok"], 201);
    }
}
