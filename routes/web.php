<?php

use App\Http\Controllers\EstagioContatoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\prospeccaoController;
use App\Http\Controllers\NichoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


// Prospeccao Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [ProspeccaoController::class, 'index'])->name('dashboard');
    Route::post('/clientes/create', [ProspeccaoController::class, 'create'])->name('clientes.create');
    Route::get('/dashboard/clientes/{id}', [ProspeccaoController::class, 'show'])->name('clientes.show'); 
    Route::put('/dashboard/clientes/{id}/update', [ProspeccaoController::class, 'update'])->name('clientes.update');
    Route::delete('/dashboard/clientes/{id}/delete', [ProspeccaoController::class, 'destroy'])->name('clientes.destroy');
});


// Nicho Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard/nichos', [NichoController::class, 'index'])->name('nichos.index');
    Route::post('/dashboard/nichos/create', [NichoController::class, 'create'])->name('nichos.create');
    Route::put('/dashboard/nichos/{id}/update', [NichoController::class, 'update'])->name('nichos.update');
    Route::delete('/dashboard/nichos/{id}/delete', [NichoController::class, 'destroy'])->name('nichos.destroy');
});


// Estagio Contato Routes
Route::middleware(["auth"])->group(function () {
   Route::get("/dashboard/estagio/de/contato", [EstagioContatoController::class, "index"])->name("estagio.de.contato.index");
   Route::post("/dashboard/estagio/de/contato/create", [EstagioContatoController::class, "create"])->name("estagio.de.contato.create");
   Route::put("/dashboard/estagio/de/contato/{id}/update", [EstagioContatoController::class, "update"])->name("estagio.de.contato.update");
   Route::delete("/dashboard/estagio/de/contato/{id}/delete", [EstagioContatoController::class, "destroy"])->name("estagio.de.contato.destroy");
});

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
