<?php

use App\Http\Controllers\Api\BeteuroanaliseController;
use Illuminate\Support\Facades\Route;



    /**
     * Routes Boxes
     */
    Route::get('/euro00', [BeteuroanaliseController::class, 'euro00']);
    Route::post('/consultar', [BeteuroanaliseController::class, 'consultar']);
    Route::get('/{id}', [BeteuroanaliseController::class, 'show']);
    Route::get('', [BeteuroanaliseController::class, 'index']);
    Route::put('/{id}', [BeteuroanaliseController::class, 'update']);
    Route::delete('/{id}', [BeteuroanaliseController::class, 'destroy']);
    Route::post('', [BeteuroanaliseController::class, 'store']);



