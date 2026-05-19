<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;

Route::resource('menu', MenuController::class);