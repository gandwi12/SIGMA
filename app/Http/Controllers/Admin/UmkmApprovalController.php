<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Umkm;
use Illuminate\Http\Request;

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