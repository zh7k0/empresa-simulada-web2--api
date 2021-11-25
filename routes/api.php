<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\EmpresaController;
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

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/feria', [EventoController::class, 'guardarFeria']);
    Route::put('/feria/{feria}', [EventoController::class, 'actualizarFeria']);

    Route::post('/feria/empresas', [EmpresaFeriaController::class, 'crear']);
    Route::put('/feria/empresas/{empresa}', [EmpresaFeriaController::class, 'actualizar']);
    Route::delete('/feria/empresas/{empresa}', [EmpresaFeriaController::class, 'eliminar']);

    Route::get('/categorias', [CategoriaController::class, 'obtenerCategorias']);
    Route::post('/categorias', [CategoriaController::class, 'crear']);
    Route::put('/categorias/{categoria}', [CategoriaController::class, 'actualizar']);
    Route::delete('/categorias/{categoria}', [CategoriaController::class, 'eliminar']);

    Route::post('/empresas', [EmpresaController::class, 'crear']);
    Route::get('/empresas/{empresa}', [EmpresaController::class, 'mostrar']);
    Route::put('/empresas/{empresa}', [EmpresaController::class, 'actualizar']);
    Route::delete('/empresas/{empresa}', [EmpresaController::class, 'eliminar']);
});

Route::get('/feria', [EventoController::class, 'obtenerFeria']);

Route::get('/feria/empresas', [EmpresaFeriaController::class, 'listarEmpresas']);
Route::get('/feria/empresas/{empresa}', [EmpresaFeriaController::class, 'mostrar']);

Route::get('/feria/visibilidad', [EventoController::class, 'esVisibleFeria']);



Route::get('/empresas', [EmpresaController::class, 'obtenerEmpresas']);
