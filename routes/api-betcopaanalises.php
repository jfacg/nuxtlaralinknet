<?php

use App\Http\Controllers\Api\BetcopaanaliseController;
use Illuminate\Support\Facades\Route;



    /**
     * Routes Boxes
     */
    Route::get('/copaover00', [BetcopaanaliseController::class, 'copaover00']);
    Route::get('/copaover20', [BetcopaanaliseController::class, 'copaover20']);
    Route::get('/copaover02', [BetcopaanaliseController::class, 'copaover02']);
    Route::get('/copa00', [BetcopaanaliseController::class, 'copa00']);
    Route::post('/consultar', [BetcopaanaliseController::class, 'consultar']);
    Route::get('/{id}', [BetcopaanaliseController::class, 'show']);
    Route::get('', [BetcopaanaliseController::class, 'index']);
    Route::put('/{id}', [BetcopaanaliseController::class, 'update']);
    Route::delete('/{id}', [BetcopaanaliseController::class, 'destroy']);
    Route::post('', [BetcopaanaliseController::class, 'store']);



