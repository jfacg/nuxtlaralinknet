<?php

use App\Http\Controllers\Api\ProjectController;
use Illuminate\Support\Facades\Route;



    /**
     * Routes Projects
     */
    Route::get('/{id}', [ProjectController::class, 'show']);
    Route::get('', [ProjectController::class, 'index']);
    Route::post('', [ProjectController::class, 'store']);
    Route::put('/{id}', [ProjectController::class, 'update']);
    Route::delete('/{id}', [ProjectController::class, 'destroy']);



