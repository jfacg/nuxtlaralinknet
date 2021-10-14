<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Clientixc;
use Illuminate\Http\Request;

class ClientIxcController extends Controller
{
    protected $clientIxc;

    public function __construct (Clientixc $clientIxc)
    {
        $this->clientIxc = $clientIxc;
    }

    public function show($id)
    {
        $clientIxc = $this->clientIxc->find($id);

        return response()->json($clientIxc, 200);
    }
}
