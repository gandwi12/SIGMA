<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::with('umkm')->get();
        
        return view('cari-makan', compact('menus'));
    }

    public function show($id)
    {
        $menu = Menu::with('umkm')->findOrFail($id);
        
        return view('detail', compact('menu'));
    }
}
