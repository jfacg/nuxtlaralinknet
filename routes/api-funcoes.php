<?php

use App\Http\Controllers\Api\RoleController;
use Illuminate\Support\Facades\Route;



        /**
     * Routes Users
     */
    Route::get('/{id}', [RoleController::class, 'show']);
    Route::get('', [RoleController::class, 'index']);
    Route::post('', [RoleController::class, 'store']);
    Route::put('/{id}', [RoleController::class, 'update']);
    Route::delete('/{id}', [RoleController::class, 'destroy']);



