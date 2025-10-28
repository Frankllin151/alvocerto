<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\prospeccaoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});



Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [ProspeccaoController::class, 'index'])->name('dashboard');
    Route::post('/clientes/create', [ProspeccaoController::class, 'create'])->name('clientes.create');
    Route::get('/dashboard/clientes/{id}', [ProspeccaoController::class, 'show'])->name('clientes.show'); 
   Route::put('/dashboard/clientes/{id}/update', [ProspeccaoController::class, 'update'])->name('clientes.update');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
