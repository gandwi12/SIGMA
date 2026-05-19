<?php

use App\Models\Menu;
use App\Models\Umkm;
use Illuminate\Http\Request;
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

// ── UMKM Routes ─────────────────────────────────────────
Route::get('/daftar-umkm', function () {
    $umkms = Umkm::where('status', 'active')->withCount('menus')->get();
    return view('daftar-umkm', compact('umkms'));
})->name('daftar-umkm');

Route::get('/umkm/{id}', function ($id) {
    $umkm = Umkm::with('menus')->findOrFail($id);
    return view('profil-umkm', compact('umkm'));
})->name('umkm.profil');

Route::get('/daftarkan-umkm', function () {
    return view('daftarkan-umkm');
})->name('daftarkan-umkm');

Route::post('/daftarkan-umkm', function (Request $request) {
    $request->validate([
        'name'            => 'required|string|max:255',
        'kategori'        => 'required|string',
        'lokasi'          => 'required|string|max:255',
        'whatsapp'        => 'required|string|max:20',
        'jam_operasional' => 'required|string|max:50',
        'description'     => 'nullable|string',
        'foto'            => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
    ]);

    $fotoPath = null;
    if ($request->hasFile('foto') && $request->file('foto')->isValid()) {
        $fotoPath = $request->file('foto')->store('umkm', 'public');
    }

    $umkm = Umkm::create([
        'name'            => $request->name,
        'kategori'        => $request->kategori,
        'lokasi'          => $request->lokasi,
        'whatsapp'        => $request->whatsapp,
        'jam_operasional' => $request->jam_operasional,
        'description'     => $request->description,
        'foto'            => $fotoPath,
        'status'          => 'pending',
        'icon'            => 'storefront',
    ]);

    return redirect()->route('daftar-umkm')
                     ->with('pending_umkm_id', $umkm->id)
                     ->with('pending_umkm_name', $umkm->name);
})->name('daftarkan-umkm.store');

Route::post('/umkm/{id}/approve', function ($id) {
    $umkm = Umkm::findOrFail($id);
    $umkm->update(['status' => 'active']);
    return response()->json(['success' => true]);
})->name('umkm.approve');
