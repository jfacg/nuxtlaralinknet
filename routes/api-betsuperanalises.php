<?php

use App\Http\Controllers\Api\BetsuperanaliseController;
use Illuminate\Support\Facades\Route;



    /**
     * Routes Boxes
     */
    Route::get('/super00', [BetsuperanaliseController::class, 'super00']);
    Route::post('/consultar', [BetsuperanaliseController::class, 'consultar']);
    Route::get('/{id}', [BetsuperanaliseController::class, 'show']);
    Route::get('', [BetsuperanaliseController::class, 'index']);
    Route::put('/{id}', [BetsuperanaliseController::class, 'update']);
    Route::delete('/{id}', [BetsuperanaliseController::class, 'destroy']);
    Route::post('', [BetsuperanaliseController::class, 'store']);



