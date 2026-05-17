<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/chatbot', [\App\Http\Controllers\ChatbotController::class, 'chat']);
Route::post('/scanner', [\App\Http\Controllers\FoodScannerController::class, 'scan']);

// Route untuk tampilan UI baru (Premium Design)
Route::get('/ai/chatbot', function () {
    return view('ai-chatbot');
});

Route::get('/ai/scanner', function () {
    return view('ai-scanner');
});

// API Routes for Chat Sessions
Route::get('/chat/sessions', [\App\Http\Controllers\ChatbotController::class, 'getSessions']);
Route::get('/chat/sessions/{id}', [\App\Http\Controllers\ChatbotController::class, 'getMessages']);
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/cari-makan', [MenuController::class, 'index'])->name('cari-makan');
Route::get('/menu/{id}', [MenuController::class, 'show'])->name('menu.detail');
