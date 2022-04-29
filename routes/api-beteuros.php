<?php

use App\Http\Controllers\Api\BetController;
use App\Http\Controllers\Api\BeteuroController;
use App\Models\Beteuro;
use Illuminate\Support\Facades\Route;



    /**
     * Routes Boxes
     */
    Route::get('/euroambas00', [BeteuroController::class, 'euroambas00']);
    Route::get('/euroambas20', [BeteuroController::class, 'euroambas20']);
    Route::get('/euroambas10', [BeteuroController::class, 'euroambas10']);
    Route::get('/dicaseuro00', [BeteuroController::class, 'dicaseuro00']);
    Route::get('/{id}', [BeteuroController::class, 'show']);
    Route::get('', [BeteuroController::class, 'index']);
    Route::put('/{id}', [BeteuroController::class, 'update']);
    Route::delete('/{id}', [BeteuroController::class, 'destroy']);
    Route::post('', [BeteuroController::class, 'store']);



