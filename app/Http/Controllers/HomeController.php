<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Umkm;

class HomeController extends Controller
{
    public function index()
    {
        $recommendedMenus = Menu::with('umkm')->where('is_recommendation', true)->get();
        $popularMenus     = Menu::with('umkm')->where('is_popular', true)->get();
        $umkms            = Umkm::all();
        
        return view('welcome', compact('recommendedMenus', 'popularMenus', 'umkms'));
    }
}
