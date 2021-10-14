<?php

use App\Http\Controllers\Api\RolePermissionController;
use Illuminate\Support\Facades\Route;



        /**
     * Routes Users
     */
    Route::get('/{id}/permissoes/{idPermission}/detach', [RolePermissionController::class, 'detachPermissionRole']);
    Route::post('/{id}/permissoes', [RolePermissionController::class, 'attachPermissionsRole']);
    Route::any('/{id}/permissoes/list', [RolePermissionController::class, 'permissionAvailable']);
    Route::get('/{id}/permissoes', [RolePermissionController::class, 'rolePermissions']);



