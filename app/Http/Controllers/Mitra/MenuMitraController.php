<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Umkm;
use App\Services\NutrisiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MenuMitraController extends Controller
{
    private function getMitraUmkm()
    {
        if (Auth::check() && Auth::user()->umkm_id) {
            return Umkm::find(Auth::user()->umkm_id);
        }

        return Umkm::where('status', 'Aktif')->latest()->first();
    }

    public function index()
    {
        $umkm = $this->getMitraUmkm();

        $menus = $umkm
            ? Menu::where('umkm_id', $umkm->id)->latest()->get()
            : collect();

        $menuTerpopuler = $menus->first();
        $menuTermurah = $menus->sortBy('harga')->first();

        return view('mitra.menu.index', compact(
            'umkm',
            'menus',
            'menuTerpopuler',
            'menuTermurah'
        ));
    }

    public function create()
    {
        return view('mitra.menu.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'required|integer|min:1000',
            'deskripsi' => 'required|string',
            'tag' => 'nullable|string|max:255',

            'kalori' => 'nullable|integer|min:0',
            'protein' => 'nullable|integer|min:0',
            'lemak' => 'nullable|integer|min:0',

            'badge_1' => 'nullable|string|max:100',
            'badge_2' => 'nullable|string|max:100',
            'badge_3' => 'nullable|string|max:100',

            'status' => 'required|in:Aktif,Nonaktif',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $umkm = $this->getMitraUmkm();

        if (!$umkm) {
            return back()->with('error', 'Akun ini belum terhubung dengan UMKM aktif.');
        }

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('menu', 'public');
        }

        $data['kalori'] = $request->filled('kalori') ? (int) $request->kalori : 0;
        $data['protein'] = $request->filled('protein') ? (int) $request->protein : 0;
        $data['lemak'] = $request->filled('lemak') ? (int) $request->lemak : 0;

        // Auto-fill nutrisi dari Gemini AI jika mitra tidak mengisi manual
        if ($data['kalori'] === 0 && $data['protein'] === 0 && $data['lemak'] === 0) {
            $nutrisi = (new NutrisiService())->getFromNamMenu($data['nama']);
            if ($nutrisi) {
                $data['kalori']  = $nutrisi['kalori'];
                $data['protein'] = $nutrisi['protein'];
                $data['lemak']   = $nutrisi['lemak'];
            }
        }

        $data['badge_1'] = $request->filled('badge_1') ? $request->badge_1 : 'Tanpa MSG';
        $data['badge_2'] = $request->filled('badge_2') ? $request->badge_2 : 'Fresh Made Every Day';
        $data['badge_3'] = $request->filled('badge_3') ? $request->badge_3 : 'Halal Certified';

        $data['umkm_id'] = $umkm->id;

        Menu::create($data);

        return redirect()
            ->route('mitra.menu.index')
            ->with('success', 'Menu berhasil ditambahkan.');
    }

    public function edit(Menu $menu)
    {
        $umkm = $this->getMitraUmkm();

        if ($umkm && $menu->umkm_id !== $umkm->id) {
            abort(403, 'Menu ini bukan milik UMKM Anda.');
        }

        return view('mitra.menu.edit', compact('menu'));
    }

    public function update(Request $request, Menu $menu)
    {
        $umkm = $this->getMitraUmkm();

        if ($umkm && $menu->umkm_id !== $umkm->id) {
            abort(403, 'Menu ini bukan milik UMKM Anda.');
        }

        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'required|integer|min:1000',
            'deskripsi' => 'required|string',
            'tag' => 'nullable|string|max:255',

            'kalori' => 'nullable|integer|min:0',
            'protein' => 'nullable|integer|min:0',
            'lemak' => 'nullable|integer|min:0',

            'badge_1' => 'nullable|string|max:100',
            'badge_2' => 'nullable|string|max:100',
            'badge_3' => 'nullable|string|max:100',

            'status' => 'required|in:Aktif,Nonaktif',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('menu', 'public');
        }

        $data['kalori'] = $request->filled('kalori') ? (int) $request->kalori : 0;
        $data['protein'] = $request->filled('protein') ? (int) $request->protein : 0;
        $data['lemak'] = $request->filled('lemak') ? (int) $request->lemak : 0;

        // Auto-fill nutrisi dari Gemini AI jika mitra tidak mengisi manual
        if ($data['kalori'] === 0 && $data['protein'] === 0 && $data['lemak'] === 0) {
            $nutrisi = (new NutrisiService())->getFromNamMenu($data['nama']);
            if ($nutrisi) {
                $data['kalori']  = $nutrisi['kalori'];
                $data['protein'] = $nutrisi['protein'];
                $data['lemak']   = $nutrisi['lemak'];
            }
        }

        $data['badge_1'] = $request->filled('badge_1') ? $request->badge_1 : 'Tanpa MSG';
        $data['badge_2'] = $request->filled('badge_2') ? $request->badge_2 : 'Fresh Made Every Day';
        $data['badge_3'] = $request->filled('badge_3') ? $request->badge_3 : 'Halal Certified';

        $menu->update($data);

        return redirect()
            ->route('mitra.menu.index')
            ->with('success', 'Menu berhasil diperbarui.');
    }

    public function destroy(Menu $menu)
    {
        $umkm = $this->getMitraUmkm();

        if ($umkm && $menu->umkm_id !== $umkm->id) {
            abort(403, 'Menu ini bukan milik UMKM Anda.');
        }

        $menu->delete();

        return redirect()
            ->route('mitra.menu.index')
            ->with('success', 'Menu berhasil dihapus.');
    }
}