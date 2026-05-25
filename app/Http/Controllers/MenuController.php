<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Review;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $minPrice = $request->min_price ?? 0;
        $maxPrice = $request->max_price ?? null;
        $distance = $request->distance ?? null;
        $category = $request->category ?? 'semua';

        $menus = Menu::with(['umkm', 'reviews'])
            ->where('status', 'Aktif')
            ->when($request->search, function ($query) use ($request) {
                $query->where('nama', 'like', '%' . $request->search . '%');
            })
            ->when($category && $category !== 'semua', function ($query) use ($category) {
                $query->where('tag', $category);
            })
            ->when($maxPrice, function ($query) use ($minPrice, $maxPrice) {
                $query->whereBetween('harga', [(int) $minPrice, (int) $maxPrice]);
            })
            ->latest()
            ->get()
            ->map(function ($menu) {
                $jarakList = [0.3, 0.5, 0.8, 1.2, 1.7, 2.4, 3.1];

                $menu->jarak_value = $jarakList[$menu->id % count($jarakList)];
                $menu->jarak = $menu->jarak_value . ' km';
                $menu->waktu = ceil($menu->jarak_value * 12) . ' mnt';

                $avgRating = $menu->reviews->avg('rating');
                $menu->rating = $avgRating ? round($avgRating, 1) : 4.8;

                return $menu;
            });

        if ($distance) {
            $menus = $menus->filter(function ($menu) use ($distance) {
                return $menu->jarak_value <= (float) $distance;
            })->values();
        }

        $categories = collect([
            (object) ['name' => 'Semua', 'slug' => 'semua'],
            (object) ['name' => 'Tinggi Protein', 'slug' => 'Tinggi Protein'],
            (object) ['name' => 'Rendah Kalori', 'slug' => 'Rendah Kalori'],
            (object) ['name' => 'Paling Hemat', 'slug' => 'Paling Hemat'],
            (object) ['name' => 'Best Seller', 'slug' => 'Best Seller'],
        ]);

        return view('pages.cari-makan', compact(
            'menus',
            'categories',
            'minPrice',
            'maxPrice',
            'distance',
            'category'
        ));
    }

    public function show(int $id)
    {
        $menu = Menu::with(['umkm', 'reviews'])->findOrFail($id);

        $relatedMenus = Menu::with('umkm')
            ->where('id', '!=', $id)
            ->where('status', 'Aktif')
            ->latest()
            ->take(4)
            ->get();

        $averageRating = $menu->reviews->avg('rating')
            ? round($menu->reviews->avg('rating'), 1)
            : 4.8;

        return view('pages.detail-menu', compact(
            'menu',
            'relatedMenus',
            'averageRating'
        ));
    }

    public function review(Request $request, int $id)
    {
        $request->validate([
            'nama_user' => 'required|string|max:100',
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'required|string|max:1000',
        ]);

        Review::create([
            'menu_id' => $id,
            'nama_user' => $request->nama_user,
            'rating' => $request->rating,
            'komentar' => $request->komentar,
        ]);

        return back()->with('success', 'Review berhasil dikirim.');
    }
}