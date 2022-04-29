<?php

use App\Http\Controllers\Api\BetcopaController;
use Illuminate\Support\Facades\Route;



    /**
     * Routes Boxes
     */
    Route::get('/copaambas00', [BetcopaController::class, 'copaambas00']);
    Route::get('/copaambas20', [BetcopaController::class, 'copaambas20']);
    Route::get('/copaambas10', [BetcopaController::class, 'copaambas10']);
    Route::get('/copaover00', [BetcopaController::class, 'copaover00']);
    Route::get('/copaambas20', [BetcopaController::class, 'copaambas20']);
    Route::get('/copaambas10', [BetcopaController::class, 'copaambas10']);
    Route::get('/{id}', [BetcopaController::class, 'show']);
    Route::get('', [BetcopaController::class, 'index']);
    Route::put('/{id}', [BetcopaController::class, 'update']);
    Route::delete('/{id}', [BetcopaController::class, 'destroy']);
    Route::post('', [BetcopaController::class, 'store']);



