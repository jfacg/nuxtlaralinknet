<?php

use App\Http\Controllers\Api\BoletoixcController;
use App\Http\Controllers\Api\IxcController;
use Illuminate\Support\Facades\Route;



    /**
     * Routes Clients
     */
    Route::get('/planos', [IxcController::class, 'listarPlanos']);
    Route::get('/cobrancas/boletosAbertos', [BoletoixcController::class, 'boletosAbertos']);




