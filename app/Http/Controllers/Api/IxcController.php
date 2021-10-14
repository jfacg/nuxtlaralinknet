<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PlanoIXC;
use Illuminate\Http\Request;

class IxcController extends Controller
{
    protected $plano;

    public function __construct (PlanoIXC $plano)
    {
        $this->plano = $plano;
    }

    public function listarPlanos()
    {
        $planos = $this->plano->all();

        return response()->json($planos, 200);
    }




}
