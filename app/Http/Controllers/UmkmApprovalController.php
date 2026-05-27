<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Umkm;
use App\Services\UmkmCredentialService;
use App\Notifications\UmkmApprovedNotification;
use Illuminate\Http\Request;

class UmkmApprovalController extends Controller
{
    private $credentialService;

    public function __construct(UmkmCredentialService $credentialService)
    {
        $this->credentialService = $credentialService;
    }

    /**
     * Approve UMKM + Auto-create User Account
     */
    public function approve(Umkm $umkm)
    {
        // Validasi email sebelum approve
        if (!$umkm->email) {
            return back()->with('error', 'Email UMKM tidak lengkap. Hubungi UMKM terlebih dahulu.');
        }

        try {
            // Generate dan buat akun user
            $credentials = $this->credentialService->createUserForUmkm($umkm);

            // Update status UMKM
            $umkm->update([
                'status' => 'Aktif'
            ]);

            // Kirim notifikasi email ke UMKM
            \Notification::route('mail', $umkm->email)
                ->notify(new UmkmApprovedNotification($umkm, $credentials));

            return back()->with('success', 
                "UMKM '{$umkm->nama_usaha}' berhasil di-approve. " .
                "Kredensial telah dikirim ke email {$umkm->email}"
            );
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal approve UMKM: ' . $e->getMessage());
        }
    }

    /**
     * Reject UMKM
     */
    public function reject(Request $request, Umkm $umkm)
    {
        $request->validate([
            'alasan' => 'required|string|min:10'
        ]);

        $umkm->update([
            'status' => 'Ditolak',
            'catatan_admin' => $request->alasan
        ]);

        return back()->with('success', "UMKM '{$umkm->nama_usaha}' berhasil ditolak.");
    }
}