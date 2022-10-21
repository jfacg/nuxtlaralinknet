<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Clientixc;
use App\Models\Loginixc;
use App\Models\PlanoIXC;
use Illuminate\Http\Request;

class IxcController extends Controller
{
    protected $plano, $loginIxc, $clienteIxc;

    public function __construct (PlanoIXC $plano, Loginixc $loginIxc, Clientixc $clienteIxc )
    {
        $this->plano = $plano;
        $this->loginIxc = $loginIxc;
        $this->clienteIxc = $clienteIxc;
    }

    public function listarPlanos ()
    {
        $planos = $this->plano->all();

        return response()->json($planos, 200);
    }

    public function listarClientesOff () 
    {
        $offfline = $this->loginIxc ->where('online', '=', 'N')
                        ->count();
        $logins = $this->loginIxc ->where('online', '=', 'N')
                    ->orderBy('ultima_conexao_final', 'desc')
                    ->get(['id', 'id_cliente', 'senha', 'login', 'mac', 'onu_mac', 'ultima_conexao_final']);

        $clientes = [];
        foreach ($logins as $login) {
            $cliente = $this->clienteIxc
                        ->where('id', '=', $login->id_cliente)
                        ->get(['id', 'razao', 'endereco', 'numero', 'bairro', 'cep']);

            $login->razao = $cliente[0]->razao;
            $login->endereco = $cliente[0]->endereco;
            $login->numero = $cliente[0]->numero;
            $login->bairro = $cliente[0]->bairro;
            $login->cep = $cliente[0]->cep;

            array_push($clientes, $login);
        }


        return response()->json(['offline' => $offfline, 'clientes' => $clientes ], 200);
    }




}
