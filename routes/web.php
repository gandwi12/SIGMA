<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/cari-makan', [MenuController::class, 'index'])->name('cari-makan');
Route::get('/menu/{id}', [MenuController::class, 'show'])->name('menu.detail');

