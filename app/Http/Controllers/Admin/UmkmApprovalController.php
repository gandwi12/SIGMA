<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Umkm;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UmkmApprovalController extends Controller
{
    public function index()
    {
        $umkms = Umkm::latest()->get();

        return view('admin.umkm-approval.index', compact('umkms'));
    }

    public function show(Umkm $umkm)
    {
        $umkm->load('photos');

        return view('admin.umkm-approval.show', compact('umkm'));
    }

    public function approve(Umkm $umkm)
    {
        $umkm->update([
            'status' => 'Aktif',
            'catatan_admin' => null,
        ]);

        // Refresh the model to ensure fresh relationship data
        $umkm->refresh();

        // Auto-create mitra account if not exists
        $existingUser = User::where('umkm_id', $umkm->id)->first();
        
        if (!$existingUser) {
            $password = Str::random(12);
            $email = strtolower(str_replace(' ', '', $umkm->nama_usaha)) . '@mitra.sigma.local';

            User::create([
                'name' => $umkm->nama_usaha,
                'email' => $email,
                'password' => Hash::make($password),
                'role' => 'mitra',
                'umkm_id' => $umkm->id,
            ]);

            return redirect()
                ->route('admin.umkm.show', $umkm->id)
                ->with('success', "UMKM berhasil disetujui. Akun mitra otomatis dibuat dengan email: {$email} dan password: {$password}. Pastikan mitra mencatat password ini!");
        }

        return redirect()
            ->route('admin.umkm.index')
            ->with('success', 'UMKM berhasil disetujui dan aktif di website.');
    }


    public function reject(Request $request, Umkm $umkm)
    {
        $request->validate([
            'catatan_admin' => 'nullable|string|max:1000',
        ]);

        $umkm->update([
            'status' => 'rejected',
            'catatan_admin' => $request->catatan_admin,
        ]);

        return redirect()
            ->route('admin.umkm.index')
            ->with('success', 'UMKM berhasil ditolak.');
    }

    public function deactivate(Umkm $umkm)
    {
        $umkm->update([
            'status' => 'Nonaktif',
        ]);

        return redirect()
            ->route('admin.umkm.index')
            ->with('success', 'UMKM berhasil dinonaktifkan.');
    }

    public function activate(Umkm $umkm)
    {
        $umkm->update([
            'status' => 'Aktif',
            'catatan_admin' => null,
        ]);

        return redirect()
            ->route('admin.umkm.index')
            ->with('success', 'UMKM berhasil diaktifkan kembali.');
    }
}