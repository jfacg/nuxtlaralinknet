<?php

use App\Http\Controllers\Api\TipoController;
use Illuminate\Support\Facades\Route;



        /**
     * Routes Users
     */
    Route::get('/listarPorClasse/{classe}', [TipoController::class, 'listarPorClasse']);
    Route::get('/{id}', [TipoController::class, 'show']);
    Route::get('', [TipoController::class, 'index']);
    Route::post('', [TipoController::class, 'store']);
    Route::put('/{id}', [TipoController::class, 'update']);
    Route::delete('/{id}', [TipoController::class, 'destroy']);



