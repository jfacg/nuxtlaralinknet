<?php

use App\Http\Controllers\Api\ClientController;
use Illuminate\Support\Facades\Route;



    /**
     * Routes Clients
     */
    Route::get('/{id}', [ClientController::class, 'show']);
    Route::post('', [ClientController::class, 'store']);
    Route::put('/{id}', [ClientController::class, 'update']);
    Route::delete('/{id}', [ClientController::class, 'destroy']);
    Route::get('', [ClientController::class, 'index']);



