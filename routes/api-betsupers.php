<?php

use App\Http\Controllers\Api\BetsuperController;
use Illuminate\Support\Facades\Route;



    /**
     * Routes Boxes
     */
    Route::get('/superambas00', [BetsuperController::class, 'superambas00']);
    Route::get('/superambas20', [BetsuperController::class, 'superambas20']);
    Route::get('/superambas10', [BetsuperController::class, 'superambas10']);
    Route::get('/{id}', [BetsuperController::class, 'show']);
    Route::get('', [BetsuperController::class, 'index']);
    Route::put('/{id}', [BetsuperController::class, 'update']);
    Route::delete('/{id}', [BetsuperController::class, 'destroy']);
    Route::post('', [BetsuperController::class, 'store']);



