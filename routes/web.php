<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PropriedadeController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\MunicipioController;
use App\Http\Controllers\ProducaoController;
use App\Http\Controllers\ProprietarioController;


use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/propriedade', [PropriedadeController::class, 'index'])->name('propriedade');
    Route::get('/produto', [ProdutoController::class, 'index'])->name('produto');
    Route::get('/municipio', [MunicipioController::class, 'index'])->name('municipio');
    Route::get('/producao/{propriedade}', [ProducaoController::class, 'index'])->name('producao');
    Route::get('/proprietario', [ProprietarioController::class, 'index'])->name('proprietario');



});

require __DIR__ . '/auth.php';
