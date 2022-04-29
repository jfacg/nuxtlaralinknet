<?php

use App\Http\Controllers\Api\BetanaliseController;
use App\Http\Controllers\Api\BetcopaanaliseController;
use Illuminate\Support\Facades\Route;



    /**
     * Routes Boxes
     */
    Route::get('/ambas0025', [BetanaliseController::class, 'ambas_00_25']);
    Route::get('/ambas2025', [BetanaliseController::class, 'ambas_20_25']);
    Route::get('/ambas1025', [BetanaliseController::class, 'ambas_10_25']);
    Route::get('/over0025', [BetanaliseController::class, 'over_00_25']);
    Route::get('/over2025', [BetanaliseController::class, 'over_20_25']);
    Route::get('/ambas1025', [BetanaliseController::class, 'ambas_10_25']);
    Route::post('/consultar', [BetanaliseController::class, 'consultar']);
   


