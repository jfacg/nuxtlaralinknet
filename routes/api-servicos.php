<?php

use App\Http\Controllers\Api\ServiceController;
use Illuminate\Support\Facades\Route;



    /**
     * Routes Clients
     */
    Route::get('/gerarboletos', [ServiceController::class, 'gerarboletos']);
    Route::get('/{id}', [ServiceController::class, 'show']);
    Route::post('', [ServiceController::class, 'store']);
    Route::put('/{id}', [ServiceController::class, 'update']);
    Route::delete('/{id}', [ServiceController::class, 'destroy']);
    Route::get('', [ServiceController::class, 'index']);



