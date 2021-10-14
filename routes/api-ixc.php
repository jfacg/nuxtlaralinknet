<?php

use App\Http\Controllers\Api\IxcController;
use App\Http\Controllers\Api\ServiceController;
use Illuminate\Support\Facades\Route;



    /**
     * Routes Clients
     */
    Route::get('/planos', [IxcController::class, 'listarPlanos']);




