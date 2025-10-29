<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\DisplayAntrian;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/display-antrian', DisplayAntrian::class)->name('display.antrian');
