<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Clientixc;
use App\Models\Loginixc;
use Illuminate\Http\Request;

class ClientIxcController extends Controller
{
    protected $clientIxc, $loginIxc;

    public function __construct (Clientixc $clientIxc, Loginixc $loginIxc)
    {
        $this->clientIxc = $clientIxc;
        $this->loginIxc = $loginIxc;
    }

    public function show($id)
    {
        $clientIxc = $this->clientIxc->find($id);

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
}
