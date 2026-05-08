<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TodoController;
use Illuminate\Support\Facades\Route;

// Pagina principală
Route::get('/', function () {
    return view('welcome');
});

// Rute protejate pentru user logat
Route::middleware('auth')->group(function () {

    // Profile Breeze edit/update
    Route::get('/profile', [ProfileController::class,'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class,'update'])->name('profile.update');

    // Dashboard
    Route::get('/dashboard', function(){ return view('dashboard'); })->name('dashboard');

    // Upload poza de profil
    Route::post('/profile/photo', [ProfileController::class, 'updatePhoto'])
        ->name('profile.photo.update');

    // CRUD todos
    Route::resource('todos', TodoController::class);
});

// Include rutele Breeze pentru login/register/logout
require __DIR__.'/auth.php';