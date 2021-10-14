<?php

use App\Http\Controllers\Api\{
    BoxController,
    ClientIxcController,
    UserController,
    RoleController,
    PermissionController,
    PortController,
    ProjectController,
    RolePermissionController,
    RoleUserController,
};
use App\Http\Controllers\Auth\AuthUserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/sanctum/token', [AuthUserController::class, 'auth']);

Route::group([
    'middleware' => ['auth:sanctum']
], function () {
    Route::get('/auth/me', [AuthUserController::class, 'me']);
    Route::post('/auth/logout', [AuthUserController::class, 'logout']);
});

Route::prefix('v1/portas')->middleware([])->group(base_path('routes/api-portas.php'));
Route::prefix('v1/caixas')->middleware([])->group(base_path('routes/api-caixas.php'));
Route::prefix('v1/projetos')->middleware([])->group(base_path('routes/api-projetos.php'));
Route::prefix('v1/clientes')->middleware([])->group(base_path('routes/api-clientes.php'));
Route::prefix('v1/services')->middleware(['auth:sanctum'])->group(base_path('routes/api-services.php'));
Route::prefix('v1/ixc')->middleware(['auth:sanctum'])->group(base_path('routes/api-ixc.php'));
Route::prefix('v1/usuarios')->middleware([])->group(base_path('routes/api-usuarios.php'));
Route::prefix('v1/usuarios')->middleware([])->group(base_path('routes/api-usuariosFuncoes.php'));
Route::prefix('v1/funcoes')->middleware([])->group(base_path('routes/api-funcoes.php'));
Route::prefix('v1/funcoes')->middleware([])->group(base_path('routes/api-funcoesPermissoes.php'));
Route::prefix('v1/permissoes')->middleware([])->group(base_path('routes/api-permissoes.php'));

Route::group([
    'prefix' => 'v1'
], function () {

    /**
     * Routes clientIxc
     */
    Route::get('/clientIxc/{id}', [ClientIxcController::class, 'show']);

    // /**
    //  * Routes Ports
    //  */
    // Route::get('/ports/{id}', [PortController::class, 'show']);
    // Route::get('/ports', [PortController::class, 'index']);
    // Route::post('/ports', [PortController::class, 'store']);
    // Route::put('/ports/{id}', [PortController::class, 'update']);
    // Route::delete('/ports/{id}', [PortController::class, 'destroy']);

    // /**
    //  * Routes Boxes
    //  */
    // Route::get('/boxes/{id}', [BoxController::class, 'show']);
    // Route::get('/boxes', [BoxController::class, 'index']);
    // Route::post('/boxes', [BoxController::class, 'store']);
    // Route::put('/boxes/{id}', [BoxController::class, 'update']);
    // Route::delete('/boxes/{id}', [BoxController::class, 'destroy']);

    // /**
    //  * Routes Projects
    //  */
    // Route::get('/projects/{id}', [ProjectController::class, 'show']);
    // Route::get('/projects', [ProjectController::class, 'index']);
    // Route::post('/projects', [ProjectController::class, 'store']);
    // Route::put('/projects/{id}', [ProjectController::class, 'update']);
    // Route::delete('/projects/{id}', [ProjectController::class, 'destroy']);

    /**
     * Routes Roles x Permissions
     */
    // Route::get('/roles/{id}/permission/{idPermission}/detach', [RolePermissionController::class, 'detachPermissionRole']);
    // Route::post('/roles/{id}/permissions', [RolePermissionController::class, 'attachPermissionsRole']);
    // Route::any('/roles/{id}/permissions/list', [RolePermissionController::class, 'permissionAvailable']);
    // Route::get('/roles/{id}/permissions', [RolePermissionController::class, 'rolePermissions']);

    // /**
    //  * Routes Users x Roles
    //  */
    // Route::get('/users/{id}/role/{idRole}/detach', [RoleUserController::class, 'detachRoleUser']);
    // Route::post('/users/{id}/roles', [RoleUserController::class, 'attachRolesUser']);
    // Route::any('/users/{id}/roles/list', [RoleUserController::class, 'rolesAvailable']);
    // Route::get('/users/{id}/roles', [RoleUserController::class, 'userRoles']);

    /**
     * Routes Permissions
     */
    Route::get('/permissions/{id}', [PermissionController::class, 'show']);
    Route::get('/permissions', [PermissionController::class, 'index']);
    Route::post('/permissions', [PermissionController::class, 'store']);
    Route::put('/permissions/{id}', [PermissionController::class, 'update']);
    Route::delete('/permissions/{id}', [PermissionController::class, 'destroy']);

    /**
     * Routes Roles
     */
    Route::get('/roles/{id}', [RoleController::class, 'show']);
    Route::get('/roles', [RoleController::class, 'index']);
    Route::post('/roles', [RoleController::class, 'store']);
    Route::put('/roles/{id}', [RoleController::class, 'update']);
    Route::delete('/roles/{id}', [RoleController::class, 'destroy']);

    // /**
    //  * Routes Users
    //  */
    // Route::get('/users/{id}', [UserController::class, 'show']);
    // Route::get('/users', [UserController::class, 'index']);
    // Route::post('/users', [UserController::class, 'store']);
    // Route::put('/users/{id}', [UserController::class, 'update']);
    // Route::delete('/users/{id}', [UserController::class, 'destroy']);







});




Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
