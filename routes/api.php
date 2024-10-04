<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CidadeController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\RepresentanteController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::apiResource('clientes', ClienteController::class);
Route::get('/clientes/{id}/edit', [ClienteController::class, 'edit']);
Route::put('/clientes/{id}', [ClienteController::class, 'update']);


Route::apiResource('cidades', CidadeController::class);
Route::get('/cidades/{id}/edit', [CidadeController::class, 'edit']);
Route::put('/cidades/{id}', [CidadeController::class, 'update']);

Route::apiResource('representantes', RepresentanteController::class);
Route::get('/representantes/{id}/edit', [RepresentanteController::class, 'edit']);
Route::put('/representantes/{id}', [RepresentanteController::class, 'update']);