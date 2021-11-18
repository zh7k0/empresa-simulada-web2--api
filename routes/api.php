<?php

use App\Http\Controllers\EmpresaFeriaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventoController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/feria', [EventoController::class, 'obtenerFeria']);
Route::post('/feria', [EventoController::class, 'guardarFeria']);
Route::put('/feria/{feria}', [EventoController::class, 'actualizarFeria']);

Route::get('/feria/empresas', [EmpresaFeriaController::class, 'listarEmpresas']);
Route::post('/feria/empresas', [EmpresaFeriaController::class, 'crear']);
Route::get('/feria/empresas/{empresa}', [EmpresaFeriaController::class, 'mostrar']);
Route::put('/feria/empresas/{empresa}', [EmpresaFeriaController::class, 'actualizar']);
Route::delete('/feria/empresas/{empresa}', [EmpresaFeriaController::class, 'eliminar']);
