<?php

use App\Http\Controllers\Api\BetcopaController;
use App\Http\Controllers\Api\BetpremierController;
use Illuminate\Support\Facades\Route;



    /**
     * Routes Boxes
     */
    Route::get('/premierambas00', [BetpremierController::class, 'premierambas00']);
    Route::get('/premierambas20', [BetpremierController::class, 'premierambas20']);
    Route::get('/premierambas10', [BetpremierController::class, 'premierambas10']);
    Route::get('/{id}', [BetpremierController::class, 'show']);
    Route::get('', [BetpremierController::class, 'index']);
    Route::put('/{id}', [BetpremierController::class, 'update']);
    Route::delete('/{id}', [BetpremierController::class, 'destroy']);
    Route::post('', [BetpremierController::class, 'store']);



