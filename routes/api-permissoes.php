<?php

use App\Http\Controllers\Api\PermissionController;
use Illuminate\Support\Facades\Route;



        /**
     * Routes Users
     */
    Route::get('/{id}', [PermissionController::class, 'show']);
    Route::get('', [PermissionController::class, 'index']);
    Route::post('', [PermissionController::class, 'store']);
    Route::put('/{id}', [PermissionController::class, 'update']);
    Route::delete('/{id}', [PermissionController::class, 'destroy']);



