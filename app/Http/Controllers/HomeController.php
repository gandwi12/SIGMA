<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Umkm;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $priceFilter = $request->get('price');
        $currentPrice = $priceFilter ? (int) $priceFilter : 15000;

        $categories = collect([
            (object) [
                'name' => 'Semua',
                'slug' => 'semua',
            ],
            (object) [
                'name' => 'Tinggi Protein',
                'slug' => 'Tinggi Protein',
            ],
            (object) [
                'name' => 'Rendah Kalori',
                'slug' => 'Rendah Kalori',
            ],
            (object) [
                'name' => 'Paling Hemat',
                'slug' => 'Paling Hemat',
            ],
            (object) [
                'name' => 'Best Seller',
                'slug' => 'Best Seller',
            ],
        ]);

        $selectedCategory = $request->get('category', 'semua');

        $baseMenuQuery = Menu::with('umkm')
            ->where('status', 'Aktif')
            ->when($priceFilter, function ($query) use ($priceFilter) {
                $query->where('harga', '<=', $priceFilter);
            })
            ->when($selectedCategory !== 'semua', function ($query) use ($selectedCategory) {
                $query->where('tag', $selectedCategory);
            });

        $menus = (clone $baseMenuQuery)
            ->latest()
            ->take(6)
            ->get();

        $popularMenus = (clone $baseMenuQuery)
            ->orderBy('harga', 'asc')
            ->take(4)
            ->get();

        $recommendedMenus = (clone $baseMenuQuery)
            ->latest()
            ->take(6)
            ->get();

        $menuRekomendasi = Menu::with('umkm')
            ->where('status', 'Aktif')
            ->where('is_featured', true)
            ->first();

        if (!$menuRekomendasi) {
            $menuRekomendasi = Menu::with('umkm')
                ->where('status', 'Aktif')
                ->when($priceFilter, function ($query) use ($priceFilter) {
                    $query->where('harga', '<=', $priceFilter);
                })
                ->latest()
                ->first();
        }

        $umkms = Umkm::where('status', 'Aktif')
            ->latest()
            ->take(6)
            ->get();

        return view('pages.home', compact(
            'menus',
            'popularMenus',
            'recommendedMenus',
            'menuRekomendasi',
            'umkms',
            'categories',
            'currentPrice',
            'priceFilter',
            'selectedCategory'
        ));
    }
}