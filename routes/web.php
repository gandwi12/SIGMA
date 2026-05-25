<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\UmkmController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\ScannerController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\UmkmApprovalController;
use App\Http\Controllers\Mitra\MenuMitraController;

use App\Models\Menu;
use App\Models\Umkm;

/*
|--------------------------------------------------------------------------
| PUBLIC USER
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/cari-makan', [MenuController::class, 'index'])->name('menu.index');
Route::get('/menu/{id}', [MenuController::class, 'show'])->name('menu.show');

Route::get('/daftar-umkm', [UmkmController::class, 'create'])->name('umkm.create');
Route::post('/daftar-umkm', [UmkmController::class, 'store'])->name('umkm.store');
Route::get('/profil-umkm/{umkm}', [UmkmController::class, 'show'])->name('umkm.show');

Route::get('/asisten-gizi', [ChatbotController::class, 'index'])->name('chatbot.index');
Route::post('/asisten-gizi/send', [ChatbotController::class, 'send'])->name('chatbot.send');

Route::post('/scanner/analyze-food', [ScannerController::class, 'analyzeFood'])
    ->name('scanner.analyze-food');

/*
|--------------------------------------------------------------------------
| AUTH GABUNGAN
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthController::class, 'loginPage'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.post');

Route::get('/register', [AuthController::class, 'registerPage'])
    ->name('register');

Route::post('/register', [AuthController::class, 'register'])
    ->name('register.post');

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');

/*
|--------------------------------------------------------------------------
| ADMIN SIGMA
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['role:admin_sigma'])
    ->group(function () {

        Route::get('/dashboard', function () {
            $totalUmkm = Umkm::count();
            $pendingUmkm = Umkm::where('status', 'pending')->count();
            $activeUmkm = Umkm::where('status', 'Aktif')->count();
            $totalMenu = Menu::count();

            return view('admin.dashboard', compact(
                'totalUmkm',
                'pendingUmkm',
                'activeUmkm',
                'totalMenu'
            ));
        })->name('dashboard');

        Route::get('/umkm', [UmkmApprovalController::class, 'index'])
            ->name('umkm.index');

        Route::get('/umkm/{umkm}', [UmkmApprovalController::class, 'show'])
            ->name('umkm.show');

        Route::post('/umkm/{umkm}/approve', [UmkmApprovalController::class, 'approve'])
            ->name('umkm.approve');

        Route::post('/umkm/{umkm}/reject', [UmkmApprovalController::class, 'reject'])
            ->name('umkm.reject');

        Route::post('/umkm/{umkm}/deactivate', [UmkmApprovalController::class, 'deactivate'])
            ->name('umkm.deactivate');

        Route::post('/umkm/{umkm}/activate', [UmkmApprovalController::class, 'activate'])
            ->name('umkm.activate');

        Route::get('/menu-monitoring', function () {
            $menus = Menu::with('umkm')->latest()->get();

            return view('admin.menu-monitoring', compact('menus'));
        })->name('menu.monitoring');

        Route::get('/analytics', function () {
            return view('admin.analytics');
        })->name('analytics');

        Route::post('/menu/{menu}/featured', function (\App\Models\Menu $menu) {\App\Models\Menu::query()->update(['is_featured' => false]);

            $menu->update(['is_featured' => true]);

            return back()->with('success', 'Menu berhasil ditampilkan di beranda.');
        })->name('menu.featured');

        Route::post('/menu/{menu}/unfeatured', function (\App\Models\Menu $menu) {
            $menu->update(['is_featured' => false]);

            return back()->with('success', 'Menu berhasil dibatalkan dari beranda.');
        })->name('menu.unfeatured');
    });

/*
|--------------------------------------------------------------------------
| MITRA UMKM
|--------------------------------------------------------------------------
*/

Route::prefix('mitra')
    ->name('mitra.')
    ->middleware(['role:mitra'])
    ->group(function () {

        Route::get('/dashboard', function () {
            $umkm = auth()->user()->umkm;

            $menus = $umkm
                ? Menu::where('umkm_id', $umkm->id)->latest()->get()
                : collect();

            return view('mitra.dashboard', compact('umkm', 'menus'));
        })->name('dashboard');

        Route::get('/profile', function () {
            $umkm = auth()->user()->umkm;

            return view('mitra.profile', compact('umkm'));
        })->name('profile');

        Route::put('/profile', function (Request $request) {
            $umkm = auth()->user()->umkm;

            if (!$umkm) {
                return back()->with('error', 'Akun ini belum terhubung dengan UMKM.');
            }

            $data = $request->validate([
                'nama_usaha' => 'required|string|max:255',
                'kategori' => 'required|string|max:255',
                'lokasi' => 'required|string|max:255',
                'alamat' => 'required|string',
                'whatsapp' => 'required|string|max:30',
                'jam_operasional' => 'required|string|max:255',
                'deskripsi' => 'nullable|string',
                'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',

                'sejarah_judul' => 'nullable|string|max:255',
                'sejarah_deskripsi' => 'nullable|string',

                'filosofi_1_judul' => 'nullable|string|max:255',
                'filosofi_1_deskripsi' => 'nullable|string',
                'filosofi_2_judul' => 'nullable|string|max:255',
                'filosofi_2_deskripsi' => 'nullable|string',
                'filosofi_3_judul' => 'nullable|string|max:255',
                'filosofi_3_deskripsi' => 'nullable|string',

                'stat_1_value' => 'nullable|string|max:50',
                'stat_1_label' => 'nullable|string|max:100',
                'stat_2_value' => 'nullable|string|max:50',
                'stat_2_label' => 'nullable|string|max:100',
                'stat_3_value' => 'nullable|string|max:50',
                'stat_3_label' => 'nullable|string|max:100',

                'fasilitas_1' => 'nullable|string|max:100',
                'fasilitas_2' => 'nullable|string|max:100',
                'fasilitas_3' => 'nullable|string|max:100',
            ]);

            if ($request->hasFile('foto')) {
                $data['foto'] = $request->file('foto')->store('umkm', 'public');
            }

            $umkm->update($data);

            return redirect()
                ->route('mitra.profile')
                ->with('success', 'Profil UMKM berhasil diperbarui.');
        })->name('profile.update');

        Route::get('/analytics', function () {
            return view('mitra.analytics');
        })->name('analytics');

        Route::get('/menu', [MenuMitraController::class, 'index'])
            ->name('menu.index');

        Route::get('/menu/create', [MenuMitraController::class, 'create'])
            ->name('menu.create');

        Route::post('/menu', [MenuMitraController::class, 'store'])
            ->name('menu.store');

        Route::get('/menu/{menu}/edit', [MenuMitraController::class, 'edit'])
            ->name('menu.edit');

        Route::put('/menu/{menu}', [MenuMitraController::class, 'update'])
            ->name('menu.update');

        Route::delete('/menu/{menu}', [MenuMitraController::class, 'destroy'])
            ->name('menu.destroy');
    });

Route::post('/menu/{id}/review', [MenuController::class, 'review'])->name('menu.review');