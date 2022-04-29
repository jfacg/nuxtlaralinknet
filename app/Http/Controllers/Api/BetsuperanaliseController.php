<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Betsuperanalise;
use Illuminate\Http\Request;

class BetsuperanaliseController extends Controller
{
    protected $entity;

    public function __construct (Betsuperanalise $bet)
    {
        $this->entity = $bet;
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

    public function consultar(Request $request)
    {
        $data = $request->all();
        $jogos = $this->entity
                    ->with(['dicajogoe', 'dicajogoc','dicajogod','jogoe','jogoc','jogod'])
                    // ->where([['dicajogoe_id', '=', $data['jogo1']], ['dicajogoc_id', '=', $data['jogo2']], ['dicajogod_id', '=', $data['jogo1']]])
                    ->get();

        return response()->json(['data' => $jogos], 200);
    }
}
