<?php

use App\Http\Controllers\Api\MaquinaController;
use Illuminate\Support\Facades\Route;

    Route::get('/{id}', [MaquinaController::class, 'show']);
    Route::get('', [MaquinaController::class, 'index']);
    Route::post('', [MaquinaController::class, 'store']);
    Route::put('/{id}', [MaquinaController::class, 'update']);
    Route::delete('/{id}', [MaquinaController::class, 'destroy']);



