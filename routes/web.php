<?php

use App\Models\Menu;
use App\Models\Umkm;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $recommendedMenus = Menu::with('umkm')->where('is_recommendation', true)->get();
    $popularMenus     = Menu::with('umkm')->where('is_popular', true)->get();
    $umkms            = Umkm::all();
    return view('welcome', compact('recommendedMenus', 'popularMenus', 'umkms'));
})->name('home');

Route::get('/cari-makan', function () {
    $menus = Menu::with('umkm')->get();
    return view('cari-makan', compact('menus'));
})->name('cari-makan');

Route::get('/menu/{id}', function ($id) {
    $menu = Menu::with('umkm')->findOrFail($id);
    return view('detail', compact('menu'));
})->name('menu.detail');

