<?php

use App\Http\Controllers\Api\BoxController;
use Illuminate\Support\Facades\Route;



    /**
     * Routes Boxes
     */
    Route::get('/ocupacao', [BoxController::class, 'ocupacao']);
    Route::get('/{id}', [BoxController::class, 'show']);
    Route::get('', [BoxController::class, 'index']);
    Route::post('', [BoxController::class, 'store']);
    Route::put('/{id}', [BoxController::class, 'update']);
    Route::delete('/{id}', [BoxController::class, 'destroy']);



