<?php

use App\Http\Controllers\Api\WatchController;
use Illuminate\Support\Facades\Route;



        /**
     * Routes Users
     */
    Route::get('/{id}', [WatchController::class, 'show']);
    Route::get('', [WatchController::class, 'index']);
    Route::post('', [WatchController::class, 'store']);
    Route::put('/{id}', [WatchController::class, 'update']);
    Route::delete('/{id}', [WatchController::class, 'destroy']);



