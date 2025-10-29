<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\DisplayAntrian;
use App\Livewire\Auth\Login;
use App\Http\Controllers\Auth\GoogleController;

Route::get('/', function () {
    return view('welcome');
});

// Auth Routes
Route::get('/login', Login::class)->name('login');

// Google OAuth Routes
Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('auth.google');
Route::get('/auth/google/callback', [GoogleController::class, 'callback'])->name('auth.google.callback');

// Application Routes
Route::get('/display-antrian', DisplayAntrian::class)->name('display.antrian');
Route::get('/ambil-antrian', \App\Livewire\AmbilAntrian::class)->name('ambil.antrian');
Route::get('/dashboard', \App\Livewire\Dashboard::class)->name('dashboard');
Route::get('/kelola-loket', \App\Livewire\KelolaLoket::class)->name('kelola.loket');
Route::get('/kelola-user', \App\Livewire\KelolaUser::class)->name('kelola.user');
Route::get('/kelola-antrian', \App\Livewire\KelolaAntrian::class)->name('kelola.antrian');
