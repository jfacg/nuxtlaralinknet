<?php

use App\Http\Controllers\Api\EquipamentoController;
use Illuminate\Support\Facades\Route;



        /**
     * Routes Users
     */
    Route::get('/{id}', [EquipamentoController::class, 'show']);
    Route::get('', [EquipamentoController::class, 'index']);
    Route::post('', [EquipamentoController::class, 'store']);
    Route::put('/{id}', [EquipamentoController::class, 'update']);
    Route::delete('/{id}', [EquipamentoController::class, 'destroy']);



