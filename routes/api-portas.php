<?php

use App\Http\Controllers\Api\PortController;
use Illuminate\Support\Facades\Route;



   /**
     * Routes Ports
     */
    Route::put('/{id}', [PortController::class, 'update']);
    Route::get('/{id}', [PortController::class, 'show']);
    Route::get('', [PortController::class, 'index']);
    Route::post('', [PortController::class, 'store']);
    Route::delete('/{id}', [PortController::class, 'destroy']);



