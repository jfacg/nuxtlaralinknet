<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Betcopaanalise;
use App\Models\Beteuroanalise;
use App\Models\Betpremieranalise;
use App\Models\Betsuperanalise;
use Illuminate\Http\Request;

class BetanaliseController extends Controller
{
    protected $betcopaanalise, $betsuperanalise, $betpremieranalise, $beteuroanalise;

    public function __construct (   Betcopaanalise $betcopaanalise, 
                                    Betsuperanalise $betsuperanalise,
                                    Betpremieranalise $betpremieranalise,
                                    Beteuroanalise $beteuroanalise
                                )
    {
        $this->betcopaanalise = $betcopaanalise;
        $this->betsuperanalise = $betsuperanalise;
        $this->betpremieranalise = $betpremieranalise;
        $this->beteuroanalise = $beteuroanalise;
    }


    public function ambas_00_25 ()
    {

        $euro = $this->beteuroanalise->with(['dicajogoe', 'dicajogoc','dicajogod','jogoe','jogoc','jogod'])
                    ->where([['analise', '=', '00ISOLADO25']])
                    ->get();
        $copa = $this->betcopaanalise->with(['dicajogoe', 'dicajogoc','dicajogod','jogoe','jogoc','jogod'])
                    ->where([['analise', '=', '00ISOLADO25']])
                    ->get();
        $premier = $this->betpremieranalise->with(['dicajogoe', 'dicajogoc','dicajogod','jogoe','jogoc','jogod'])
                    ->where([['analise', '=', '00ISOLADO25']])
                    ->get();
        $super = $this->betsuperanalise->with(['dicajogoe', 'dicajogoc','dicajogod','jogoe','jogoc','jogod'])
                    ->where([['analise', '=', '00ISOLADO25']])
                    ->get();
        
        $jogos = [];


        foreach ($premier as $jogo) {
            array_push($jogos, $jogo);
        }

        foreach ($euro as $jogo) {
            array_push($jogos, $jogo);
        }

        foreach ($copa as $jogo) {
            array_push($jogos, $jogo);
        }

        foreach ($super as $jogo) {
            array_push($jogos, $jogo);
        }

        $listaBets = [];

        foreach ($jogos as $jogo) {
            $jogoe = $jogo->dicajogoe->placar;
            $jogoc = $jogo->dicajogoc->placar;
            $jogod = $jogo->dicajogod->placar;
            $rep = -1;
            
            foreach ($jogos as $jogo1) {
                if ($jogoe == $jogo1->dicajogoe->placar && $jogoc == $jogo1->dicajogoc->placar && $jogod == $jogo1->dicajogod->placar ) {
                    $rep = $rep + 1;
                }
            }
            $jogo->repetida = $rep;
            array_push($listaBets, $jogo);
        }

        $lista= [];

        foreach ($listaBets as $key => $jogo) {
            $item['data'] = $jogo->dicajogoc->data;
            $item['hora'] = $jogo->dicajogoc->hora;
            $item['minuto'] = $jogo->dicajogoc->minuto;
            $item['green'] = $jogo->green;
            $item['tipo'] = $jogo->tipo;
            $item['status'] = $jogo->status;
            array_push($lista, $item);
        }

        return response()->json(['data' => $listaBets, 'contadores' => $lista], 200);
    }


    public function ambas_20_25 ()
    {

        $euro = $this->beteuroanalise->with(['dicajogoe', 'dicajogoc','dicajogod','jogoe','jogoc','jogod'])
                    ->where([['analise', '=', '20ISOLADO25']])
                    ->get();
        $copa = $this->betcopaanalise->with(['dicajogoe', 'dicajogoc','dicajogod','jogoe','jogoc','jogod'])
                    ->where([['analise', '=', '20ISOLADO25']])
                    ->get();
        $premier = $this->betpremieranalise->with(['dicajogoe', 'dicajogoc','dicajogod','jogoe','jogoc','jogod'])
                    ->where([['analise', '=', '20ISOLADO25']])
                    ->get();
        $super = $this->betsuperanalise->with(['dicajogoe', 'dicajogoc','dicajogod','jogoe','jogoc','jogod'])
                    ->where([['analise', '=', '20ISOLADO25']])
                    ->get();
        
        $jogos = [];


        foreach ($premier as $jogo) {
            array_push($jogos, $jogo);
        }

        foreach ($euro as $jogo) {
            array_push($jogos, $jogo);
        }

        foreach ($copa as $jogo) {
            array_push($jogos, $jogo);
        }

        foreach ($super as $jogo) {
            array_push($jogos, $jogo);
        }

        $listaBets = [];

        foreach ($jogos as $jogo) {
            $jogoe = $jogo->dicajogoe->placar;
            $jogoc = $jogo->dicajogoc->placar;
            $jogod = $jogo->dicajogod->placar;
            $rep = -1;
            
            foreach ($jogos as $jogo1) {
                if ($jogoe == $jogo1->dicajogoe->placar && $jogoc == $jogo1->dicajogoc->placar && $jogod == $jogo1->dicajogod->placar ) {
                    $rep = $rep + 1;
                }
            }
            $jogo->repetida = $rep;
            array_push($listaBets, $jogo);
        }

        
        return response()->json(['data' => $listaBets], 200);
    }

    public function ambas_10_25 ()
    {

        $euro = $this->beteuroanalise->with(['dicajogoe', 'dicajogoc','dicajogod','jogoe','jogoc','jogod'])
                    ->where([['analise', '=', '10ISOLADO25']])
                    ->get();
        $copa = $this->betcopaanalise->with(['dicajogoe', 'dicajogoc','dicajogod','jogoe','jogoc','jogod'])
                    ->where([['analise', '=', '10ISOLADO25']])
                    ->get();
        $premier = $this->betpremieranalise->with(['dicajogoe', 'dicajogoc','dicajogod','jogoe','jogoc','jogod'])
                    ->where([['analise', '=', '10ISOLADO25']])
                    ->get();
        $super = $this->betsuperanalise->with(['dicajogoe', 'dicajogoc','dicajogod','jogoe','jogoc','jogod'])
                    ->where([['analise', '=', '10ISOLADO25']])
                    ->get();
        
        $jogos = [];


        foreach ($premier as $jogo) {
            array_push($jogos, $jogo);
        }

        foreach ($euro as $jogo) {
            array_push($jogos, $jogo);
        }

        foreach ($copa as $jogo) {
            array_push($jogos, $jogo);
        }

        foreach ($super as $jogo) {
            array_push($jogos, $jogo);
        }

        $listaBets = [];

        foreach ($jogos as $jogo) {
            $jogoe = $jogo->dicajogoe->placar;
            $jogoc = $jogo->dicajogoc->placar;
            $jogod = $jogo->dicajogod->placar;
            $rep = -1;
            
            foreach ($jogos as $jogo1) {
                if ($jogoe == $jogo1->dicajogoe->placar && $jogoc == $jogo1->dicajogoc->placar && $jogod == $jogo1->dicajogod->placar ) {
                    $rep = $rep + 1;
                }
            }
            $jogo->repetida = $rep;
            array_push($listaBets, $jogo);
        }

        
        return response()->json(['data' => $listaBets], 200);
    }

    public function over_00_25 ()
    {

        $euro = $this->beteuroanalise->with(['dicajogoe', 'dicajogoc','dicajogod','jogoe','jogoc','jogod'])
                    ->where([['analise', '=', '00ISOLADO25']])
                    ->where([['tipo', '=', 'OVER']])
                    ->get();
        $copa = $this->betcopaanalise->with(['dicajogoe', 'dicajogoc','dicajogod','jogoe','jogoc','jogod'])
                    ->where([['analise', '=', '00ISOLADO25']])
                    ->where([['tipo', '=', 'OVER']])
                    ->get();
        $premier = $this->betpremieranalise->with(['dicajogoe', 'dicajogoc','dicajogod','jogoe','jogoc','jogod'])
                    ->where([['analise', '=', '00ISOLADO25']])
                    ->where([['tipo', '=', 'OVER']])
                    ->get();
        $super = $this->betsuperanalise->with(['dicajogoe', 'dicajogoc','dicajogod','jogoe','jogoc','jogod'])
                    ->where([['analise', '=', '00ISOLADO25']])
                    ->where([['tipo', '=', 'OVER']])
                    ->get();
        
        $jogos = [];


        foreach ($premier as $jogo) {
            array_push($jogos, $jogo);
        }

        foreach ($euro as $jogo) {
            array_push($jogos, $jogo);
        }

        foreach ($copa as $jogo) {
            array_push($jogos, $jogo);
        }

        foreach ($super as $jogo) {
            array_push($jogos, $jogo);
        }

        $listaBets = [];

        foreach ($jogos as $jogo) {
            $jogoe = $jogo->dicajogoe->placar;
            $jogoc = $jogo->dicajogoc->placar;
            $jogod = $jogo->dicajogod->placar;
            $rep = -1;
            
            foreach ($jogos as $jogo1) {
                if ($jogoe == $jogo1->dicajogoe->placar && $jogoc == $jogo1->dicajogoc->placar && $jogod == $jogo1->dicajogod->placar ) {
                    $rep = $rep + 1;
                }
            }
            $jogo->repetida = $rep;
            array_push($listaBets, $jogo);
        }

        $lista= [];

        foreach ($listaBets as $key => $jogo) {
            $item['data'] = $jogo->dicajogoc->data;
            $item['hora'] = $jogo->dicajogoc->hora;
            $item['minuto'] = $jogo->dicajogoc->minuto;
            $item['green'] = $jogo->green;
            $item['tipo'] = $jogo->tipo;
            $item['status'] = $jogo->status;
            array_push($lista, $item);
        }

        return response()->json(['data' => $listaBets, 'contadores' => $lista], 200);
    }


    public function over_20_25 ()
    {

        $euro = $this->beteuroanalise->with(['dicajogoe', 'dicajogoc','dicajogod','jogoe','jogoc','jogod'])
                    ->where([['analise', '=', '20ISOLADO25']])
                    ->where([['tipo', '=', 'OVER']])
                    ->get();
        $copa = $this->betcopaanalise->with(['dicajogoe', 'dicajogoc','dicajogod','jogoe','jogoc','jogod'])
                    ->where([['analise', '=', '20ISOLADO25']])
                    ->where([['tipo', '=', 'OVER']])
                    ->get();
        $premier = $this->betpremieranalise->with(['dicajogoe', 'dicajogoc','dicajogod','jogoe','jogoc','jogod'])
                    ->where([['analise', '=', '20ISOLADO25']])
                    ->where([['tipo', '=', 'OVER']])
                    ->get();
        $super = $this->betsuperanalise->with(['dicajogoe', 'dicajogoc','dicajogod','jogoe','jogoc','jogod'])
                    ->where([['analise', '=', '20ISOLADO25']])
                    ->where([['tipo', '=', 'OVER']])
                    ->get();
        
        $jogos = [];


        foreach ($premier as $jogo) {
            array_push($jogos, $jogo);
        }

        foreach ($euro as $jogo) {
            array_push($jogos, $jogo);
        }

        foreach ($copa as $jogo) {
            array_push($jogos, $jogo);
        }

        foreach ($super as $jogo) {
            array_push($jogos, $jogo);
        }

        $listaBets = [];

        foreach ($jogos as $jogo) {
            $jogoe = $jogo->dicajogoe->placar;
            $jogoc = $jogo->dicajogoc->placar;
            $jogod = $jogo->dicajogod->placar;
            $rep = -1;
            
            foreach ($jogos as $jogo1) {
                if ($jogoe == $jogo1->dicajogoe->placar && $jogoc == $jogo1->dicajogoc->placar && $jogod == $jogo1->dicajogod->placar ) {
                    $rep = $rep + 1;
                }
            }
            $jogo->repetida = $rep;
            array_push($listaBets, $jogo);
        }

        $lista= [];

        foreach ($listaBets as $key => $jogo) {
            $item['data'] = $jogo->dicajogoc->data;
            $item['hora'] = $jogo->dicajogoc->hora;
            $item['minuto'] = $jogo->dicajogoc->minuto;
            $item['green'] = $jogo->green;
            $item['tipo'] = $jogo->tipo;
            $item['status'] = $jogo->status;
            array_push($lista, $item);
        }

        return response()->json(['data' => $listaBets, 'contadores' => $lista], 200);
    }

    

    public function consultar(Request $request)
    {
        $data = $request->all();
        $consulta = explode("\t", $data['placares']);
        $jogos = [];

        $euro = $this->beteuroanalise
                    ->with(['dicajogoe', 'dicajogoc','dicajogod','jogoe','jogoc','jogod'])
                    ->get();
        foreach ($euro as $jogo) {
            if ($jogo->dicajogoe->placar == $consulta[0]) {
                if ($jogo->dicajogoc->placar == $consulta[1]) {
                    if ($jogo->dicajogod->placar == $consulta[2]) {
                        array_push($jogos, $jogo);
                    }
                }
            }
        }

        
        $copa = $this->betcopaanalise
                    ->with(['dicajogoe', 'dicajogoc','dicajogod','jogoe','jogoc','jogod'])
                    ->get();
        foreach ($copa as $jogo) {
            if ($jogo->dicajogoe->placar == $consulta[0]) {
                if ($jogo->dicajogoc->placar == $consulta[1]) {
                    if ($jogo->dicajogod->placar == $consulta[2]) {
                        array_push($jogos, $jogo);
                    }
                }
            }
        }

        
        $premier = $this->betpremieranalise
                    ->with(['dicajogoe', 'dicajogoc','dicajogod','jogoe','jogoc','jogod'])
                    ->get();
        foreach ($premier as $jogo) {
            if ($jogo->dicajogoe->placar == $consulta[0]) {
                if ($jogo->dicajogoc->placar == $consulta[1]) {
                    if ($jogo->dicajogod->placar == $consulta[2]) {
                        array_push($jogos, $jogo);
                    }
                }
            }
        }

        
        $super = $this->betsuperanalise
                    ->with(['dicajogoe', 'dicajogoc','dicajogod','jogoe','jogoc','jogod'])
                    ->get();
        foreach ($super as $jogo) {
            if ($jogo->dicajogoe->placar == $consulta[0]) {
                if ($jogo->dicajogoc->placar == $consulta[1]) {
                    if ($jogo->dicajogod->placar == $consulta[2]) {
                        array_push($jogos, $jogo);
                    }
                }
            }
        }

        

        return response()->json(['data' => $jogos], 200);
    }
}
