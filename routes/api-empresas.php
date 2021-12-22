<?php

use App\Http\Controllers\Api\EmpresaController;
use Illuminate\Support\Facades\Route;



        /**
     * Routes Users
     */
    Route::get('/{id}', [EmpresaController::class, 'show']);
    Route::get('', [EmpresaController::class, 'index']);
    Route::post('', [EmpresaController::class, 'store']);
    Route::put('/{id}', [EmpresaController::class, 'update']);
    Route::delete('/{id}', [EmpresaController::class, 'destroy']);



