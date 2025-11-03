<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\DisplayAntrian;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\GoogleCallback;
use App\Http\Controllers\Auth\GoogleController;

Route::get('/', function () {
    return view('welcome');
});

// Auth Routes
Route::get('/login', Login::class)->name('login');
Route::get('/auth/callback', GoogleCallback::class)->name('auth.callback');
Route::post('/logout', [\App\Livewire\Auth\Logout::class, 'logout'])->name('logout');

// Google OAuth Routes
Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('auth.google');
Route::get('/auth/google/callback', [GoogleController::class, 'callback'])->name('auth.google.callback');

// Public Routes
Route::get('/display-antrian', DisplayAntrian::class)->name('display.antrian');
Route::get('/ambil-antrian', \App\Livewire\AmbilAntrian::class)->name('ambil.antrian');

// Protected Routes - Require Authentication
Route::middleware('auth.custom')->group(function () {
    Route::get('/dashboard', \App\Livewire\Dashboard::class)->name('dashboard');
    Route::get('/kelola-loket', \App\Livewire\KelolaLoket::class)->name('kelola.loket');
    Route::get('/kelola-user', \App\Livewire\KelolaUser::class)->name('kelola.user');
    Route::get('/kelola-antrian', \App\Livewire\KelolaAntrian::class)->name('kelola.antrian');
});
