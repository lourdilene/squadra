<?php

use App\Http\Controllers\BairroController;
use App\Http\Controllers\MunicipioController;
use App\Http\Controllers\PessoaController;
use App\Http\Controllers\UfController;
use Illuminate\Support\Facades\Route;

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
Route::apiResource('pessoa', PessoaController::class);

Route::apiResource('uf', UfController::class);

Route::apiResource('bairro', BairroController::class);

Route::apiResource('municipio', MunicipioController::class);
