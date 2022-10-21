<?php

use App\Http\Controllers\Api\PesqInstalacaoController;
use Illuminate\Support\Facades\Route;



        /**
     * Routes Users
     */
    Route::get('/pesquisaDadosGrafico', [PesqInstalacaoController::class, 'pesquisaDadosGrafico']);
//     Route::get('/{id}', [PesqInstalacaoController::class, 'show']);
    Route::get('', [PesqInstalacaoController::class, 'index']);
//     Route::post('', [PesqInstalacaoController::class, 'store']);
    Route::put('/{id}', [PesqInstalacaoController::class, 'update']);
//     Route::delete('/{id}', [PesqInstalacaoController::class, 'destroy']);



