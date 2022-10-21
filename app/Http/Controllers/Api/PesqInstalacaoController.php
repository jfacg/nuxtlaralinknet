<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pesqinstalacao;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PesqInstalacaoController extends Controller
{
    protected $entity;

    public function __construct (Pesqinstalacao $pesquisa)
    {
        $this->entity = $pesquisa;
    }

    public function index()
    {
        $pesquisas = $this->entity->all();
        return response()->json($pesquisas, 200);
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

    public function pesquisaDadosGrafico()
    {
        $pesquisas = $this->entity
                        ->where("fase", "=", "CONCLUIDO")
                        ->get();
        $dados = [];
        $anoDados = [];
        $jan = [];
        $fev = [];
        $mar = [];
        $abr = [];
        $mai = [];
        $jun = [];
        $jul = [];
        $ago = [];
        $set = [];
        $out = [];
        $nov = [];
        $dez = [];

        foreach ($pesquisas as $pesquisa) {
            $dt = Carbon::parse($pesquisa->dataFase1);
            $ano = $dt->year;
            $mes = $dt->month;
            $dia = $dt->day;
            
            if ($mes == 1) {
               array_push($jan, $pesquisa); 
            }
            if ($mes == 2) {
               array_push($fev, $pesquisa); 
            }
            if ($mes == 3) {
               array_push($mar, $pesquisa); 
            }
            if ($mes == 4) {
               array_push($abr, $pesquisa); 
            }
            if ($mes == 5) {
               array_push($mai, $pesquisa); 
            }
            if ($mes == 6) {
               array_push($jun, $pesquisa); 
            }
            if ($mes == 7) {
               array_push($jul, $pesquisa); 
            }
            if ($mes == 8) {
               array_push($ago, $pesquisa); 
            }
            if ($mes == 9) {
               array_push($set, $pesquisa); 
            }
            if ($mes == 10) {
               array_push($out, $pesquisa); 
            }
            if ($mes == 11) {
               array_push($nov, $pesquisa); 
            }
            if ($mes == 12) {
               array_push($dez, $pesquisa); 
            }
        }

        $fase1 = [
            'APROVADO' => 0,
        ];

        foreach ($jul as $dado) {
             if ($dado->status1 == 'APROVADO') {
                $fase1['APROVADO']++;
             }
        }


        $dados["jan"]= $jan;
        $dados["fev"]= $fev;
        $dados["mar"]= $mar;
        $dados["abr"]= $abr;
        $dados["mai"]= $mai;
        $dados["jun"]= $jun;
        $dados["jul"]= [
            'fase1' => $fase1
        ];
        $dados["ago"]= $ago;
        $dados["set"]= $set;
        $dados["out"]= $out;
        $dados["nov"]= $nov;
        $dados["dez"]= $dez;




        return response()->json(['data' => $dados], 200);
    }

   

    


}
