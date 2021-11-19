<?php

use App\Http\Controllers\Api\BoletoixcController;
use App\Http\Controllers\Api\ClientIxcController;
use App\Http\Controllers\Api\IxcController;
use Illuminate\Support\Facades\Route;



    /**
     * Routes Clients
     */
    Route::get('/planos', [IxcController::class, 'listarPlanos']);
    Route::get('/cobrancas/boletosAbertos', [BoletoixcController::class, 'boletosAbertos']);
    Route::get('/cliente/{id}', [ClientIxcController::class, 'show']);




