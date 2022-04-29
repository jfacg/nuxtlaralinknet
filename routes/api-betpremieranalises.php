<?php

use App\Http\Controllers\Api\BetpremieranaliseController;
use Illuminate\Support\Facades\Route;



    /**
     * Routes Boxes
     */
    Route::get('/premier00', [BetpremieranaliseController::class, 'premier00']);
    Route::post('/consultar', [BetpremieranaliseController::class, 'consultar']);
    Route::get('/{id}', [BetpremieranaliseController::class, 'show']);
    Route::get('', [BetpremieranaliseController::class, 'index']);
    Route::put('/{id}', [BetpremieranaliseController::class, 'update']);
    Route::delete('/{id}', [BetpremieranaliseController::class, 'destroy']);
    Route::post('', [BetpremieranaliseController::class, 'store']);



