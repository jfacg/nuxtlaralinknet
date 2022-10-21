<?php

use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;



        /**
     * Routes Users
     */
    Route::get('desbloqueados', [UserController::class, 'desbloqueados']);
    Route::get('/{id}', [UserController::class, 'show']);
    Route::get('', [UserController::class, 'index']);
    Route::post('', [UserController::class, 'store']);
    Route::put('/{id}', [UserController::class, 'update']);
    Route::delete('/{id}', [UserController::class, 'destroy']);



