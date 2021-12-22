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

Route::prefix('v1/empresas')->middleware([])->group(base_path('routes/api-empresas.php'));
Route::prefix('v1/cobrancas')->middleware([])->group(base_path('routes/api-cobrancas.php'));
Route::prefix('v1/servicos')->middleware([])->group(base_path('routes/api-servicos.php'));
Route::prefix('v1/portas')->middleware([])->group(base_path('routes/api-portas.php'));
Route::prefix('v1/caixas')->middleware([])->group(base_path('routes/api-caixas.php'));
Route::prefix('v1/projetos')->middleware([])->group(base_path('routes/api-projetos.php'));
Route::prefix('v1/clientes')->middleware([])->group(base_path('routes/api-clientes.php'));
Route::prefix('v1/ixc')->middleware([])->group(base_path('routes/api-ixc.php'));
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
});




Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
