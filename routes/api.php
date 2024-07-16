<?php

use App\Http\Controllers\AdjuntoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Activity_log;
use App\Http\Controllers\Admin\AmbitoController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\InformeController;
use App\Http\Controllers\Admin\ManageApiUserController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\ProductoController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\TipoBienController;
use App\Http\Controllers\Admin\UsersPermissionsController;
use App\Http\Controllers\Admin\UsersRolesController;
use App\Http\Controllers\BienController;
use App\Http\Controllers\PersonaController;
use App\Http\Controllers\UbicacionController;
use Spatie\Permission\Contracts\Permission;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', [ManageApiUserController::class, 'login'])->name('api.login');
Route::get('isAuthenticated', [ManageApiUserController::class, 'isAuthenticated'])->name('api.isAuthenticated');

//Route::middleware('auth:sanctum')->group(function () {
    Route::resource('user', UserController::class);
    Route::put('users/{user}/roles', [UsersRolesController::class, 'update'])->name('admin.users.roles.update');
    Route::put('users/{user}/permissions', [UsersPermissionsController::class, 'update'])->name('admin.users.permissions.update');

    Route::resource('role', RoleController::class);
    Route::put('role/{role}/updatePermissions', [RoleController::class, 'updatePermissions'])->name('role.updatePermissions');
    Route::resource('permission', PermissionController::class);

    Route::resource('informe', InformeController::class);
    Route::get('parametrosInforme', [InformeController::class, 'parametrosInf'])->name('informe.parametros');

    Route::resource('adjunto', AdjuntoController::class);

    Route::resource('persona', PersonaController::class);
    Route::get('personasInforme/{Id}', [PersonaController::class, 'indexPersonasInforme'])->name('personas.informe');

    Route::resource('bien', BienController::class);
    Route::get('biensInforme/{Id}', [BienController::class, 'indexBienesInforme'])->name('biens.informe');
    Route::get('parametrosBien', [BienController::class, 'parametrosBien'])->name('informe.parametros');

    Route::resource('ubicaciones', UbicacionController::class);
    Route::get('ubicacionesinforme/{Id}', [UbicacionController::class, 'ubicacionesinforme'])->name('ubicaciones.informe');

    Route::resource('ambito', AmbitoController::class);
    Route::resource('producto', ProductoController::class);
    Route::resource('tipobien', TipoBienController::class);

    Route::get('bitacora', [Activity_log::class, 'index'])->name('bitacora');

    Route::post('logout', [ManageApiUserController::class, 'logout'])->name('api.logout');
//});
