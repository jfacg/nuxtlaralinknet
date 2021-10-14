<?php

use App\Http\Controllers\Api\RoleUserController;
use Illuminate\Support\Facades\Route;



    /**
     * Routes Users x Roles
     */
    Route::get('/{id}/funcoes/{idRole}/detach', [RoleUserController::class, 'detachRoleUser']);
    Route::post('/{id}/funcoes', [RoleUserController::class, 'attachRolesUser']);
    Route::any('/{id}/funcoes/list', [RoleUserController::class, 'rolesAvailable']);
    Route::get('/{id}/funcoes', [RoleUserController::class, 'userRoles']);



