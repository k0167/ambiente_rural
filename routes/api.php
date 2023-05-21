<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PropriedadeController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\MunicipioController;
use App\Http\Controllers\ProducaoController;


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


Route::post('/propriedade/update', [PropriedadeController::class, 'update'])->name('propriedade.update');
Route::post('/propriedade', [PropriedadeController::class, 'store'])->name('propriedade.store');
Route::get('/propriedades', [PropriedadeController::class, 'getPropriedades'])->name('propriedades.get');
Route::post('/propriedade/{id}', [PropriedadeController::class, 'destroy'])->name('propriedade.destroy');

Route::post('/produto/update', [ProdutoController::class, 'update'])->name('produto.update');
Route::post('/produto', [ProdutoController::class, 'store'])->name('produto.store');
Route::get('/produtos', [ProdutoController::class, 'getProdutos'])->name('produtos.get');
Route::post('/produto/{id}', [ProdutoController::class, 'destroy'])->name('produto.destroy');

Route::post('/municipio/update', [MunicipioController::class, 'update'])->name('municipio.update');
Route::post('/municipio', [MunicipioController::class, 'store'])->name('municipio.store');
Route::get('/municipios', [MunicipioController::class, 'getMunicipios'])->name('municipios.get');
Route::post('/municipio/{id}', [MunicipioController::class, 'destroy'])->name('municipio.destroy');

Route::post('/producao/update', [ProducaoController::class, 'update'])->name('producao.update');
Route::post('/producao', [ProducaoController::class, 'store'])->name('producao.store');
Route::get('/producoes/{propriedade}', [ProducaoController::class, 'getProducoes'])->name('producoes.get');
Route::post('/producao/{id}', [ProducaoController::class, 'destroy'])->name('producao.destroy');



