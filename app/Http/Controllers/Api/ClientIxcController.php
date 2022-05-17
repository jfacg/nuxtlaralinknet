<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Clientixc;
use App\Models\Loginixc;
use Illuminate\Http\Request;
use App\Models\Telegram\AlertTeste;

class ClientIxcController extends Controller
{
    protected $clientIxc, $loginIxc;

    public function __construct (Clientixc $clientIxc, Loginixc $loginIxc)
    {
        $this->clientIxc = $clientIxc;
        $this->loginIxc = $loginIxc;
    }

    public function loginoffline($status)
    {

        $offfline1 = $this->loginIxc ->where('online', '=', 'N')
                        ->count();

        // if ($status) {
        //     $offfline1 = $this->loginIxc ->where('online', '=', 'N')
        //                 ->count();

        //     while ($status) {
        //         $offfline2 = $this->loginIxc ->where('online', '=', 'N')
        //                 ->count();
        //         $caiu = $offfline2 - $offfline1;

        //         if ($caiu > 1) {
        //             AlertTeste::enviarMensagem("Caiu: ".$caiu);
        //         }
        //     }


        // }


        // $offfline = $this->loginIxc ->where('online', '=', 'N')
        //                 ->count();

        $logins = $this->loginIxc ->where('online', '=', 'N')
                    ->orderBy('ultima_conexao_final', 'desc')
                    ->get(['id', 'id_cliente', 'senha', 'login', 'mac', 'onu_mac', 'ultima_conexao_final'  ]);

        return response()->json(['offline' => $offfline, 'logins' => $logins ], 200);
    }

    public function telegram()
    {
        AlertTeste::enviarMensagem('testeando');
    }

    public function show($id)
    {
        $clientIxc = $this->clientIxc->find($id);

        if ($clientIxc) {
            $logins = $this->loginIxc
                    ->where('id_cliente', '=', $clientIxc->id)
                    ->orderBy('id_contrato', 'desc')
                    ->get();
            $clientIxc->logins = $logins;
        }

        return response()->json($clientIxc, 200);
    
    }
    public function buscarPorCpf($cpf)
    {
        $clientIxc = $this->clientIxc->where('cnpj_cpf', '=', $cpf)->first();

        if ($clientIxc) {
            $logins = $this->loginIxc
                    ->where('id_cliente', '=', $clientIxc->id)
                    ->orderBy('id_contrato', 'desc')
                    ->get();
            $clientIxc->logins = $logins;
        }

        return response()->json(['data' => $clientIxc], 200);
    }

    public function buscarPorNome ($nome)
    {
        $clientIxc = $this->clientIxc->pesquisar($nome);

        return response()->json(['data' => $clientIxc], 200);
    }
}
