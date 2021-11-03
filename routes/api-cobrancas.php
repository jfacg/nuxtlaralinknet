<?php

use App\Http\Controllers\Api\CobrancaController;
use Illuminate\Support\Facades\Route;



    /**
     * Routes Projects
     */
    Route::get('/boletoixc/{boletoixc_id}', [CobrancaController::class, 'boletoixcid']);
    // Route::get('/{id}', [CobrancaController::class, 'show']);
    Route::post('', [CobrancaController::class, 'store']);
    Route::get('', [CobrancaController::class, 'index']); 
    // Route::put('/{id}', [CobrancaController::class, 'update']);
    // Route::delete('/{id}', [CobrancaController::class, 'destroy']);



