<?php

use App\Http\Controllers\Api\BoletoixcController;
use App\Http\Controllers\Api\ClientIxcController;
use App\Http\Controllers\Api\IxcController;
use Illuminate\Support\Facades\Route;



    /**
     * Routes Clients
     */
    Route::get('/listarClientesOff', [IxcController::class, 'listarClientesOff']);
    Route::get('/planos', [IxcController::class, 'listarPlanos']);
    Route::get('/cobrancas/boletosAbertos', [BoletoixcController::class, 'boletosAbertos']);
    Route::get('/cliente/buscarPorCpf/{cpf}', [ClientIxcController::class, 'buscarPorCpf']);
    Route::get('/cliente/buscarPorNome/{nome}', [ClientIxcController::class, 'buscarPorNome']);
    Route::get('/cliente/{id}', [ClientIxcController::class, 'show']);

    Route::get('/telegram', [ClientIxcController::class, 'telegram']);
    Route::post('/loginoffline/{status}', [ClientIxcController::class, 'loginoffline']);




