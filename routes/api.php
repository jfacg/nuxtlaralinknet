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

Route::prefix('v1/betanalise')->middleware([])->group(base_path('routes/api-betanalise.php'));
Route::prefix('v1/betsuperanalises')->middleware([])->group(base_path('routes/api-betsuperanalises.php'));
Route::prefix('v1/betsupers')->middleware([])->group(base_path('routes/api-betsupers.php'));
Route::prefix('v1/betpremieranalises')->middleware([])->group(base_path('routes/api-betpremieranalises.php'));
Route::prefix('v1/betpremiers')->middleware([])->group(base_path('routes/api-betpremiers.php'));
Route::prefix('v1/betcopaanalises')->middleware([])->group(base_path('routes/api-betcopaanalises.php'));
Route::prefix('v1/betcopas')->middleware([])->group(base_path('routes/api-betcopas.php'));
Route::prefix('v1/beteuroanalises')->middleware([])->group(base_path('routes/api-beteuroanalises.php'));
Route::prefix('v1/beteuros')->middleware([])->group(base_path('routes/api-beteuros.php'));
Route::prefix('v1/maquinas')->middleware([])->group(base_path('routes/api-maquinas.php'));
Route::prefix('v1/tipos')->middleware([])->group(base_path('routes/api-tipos.php'));
Route::prefix('v1/watches')->middleware([])->group(base_path('routes/api-watches.php'));
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
