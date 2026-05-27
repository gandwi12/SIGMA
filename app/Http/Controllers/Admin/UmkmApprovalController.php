<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Umkm;
use App\Models\User;
use App\Services\UmkmCredentialService;
use App\Notifications\UmkmApprovedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Hash;

class UmkmApprovalController extends Controller
{
    private $credentialService;

    public function __construct(UmkmCredentialService $credentialService)
    {
        $this->credentialService = $credentialService;
    }

    /**
     * List semua UMKM (pending & approved)
     */
    public function index()
    {
        $umkms = Umkm::latest()->get();
        return view('admin.umkm-approval.index', compact('umkms'));
    }

    /**
     * Show detail UMKM
     */
    public function show(Umkm $umkm)
    {
        return view('admin.umkm-approval.show', compact('umkm'));
    }

    /**
     * Approve UMKM + Auto-create User Account
     */
    public function approve(Umkm $umkm)
    {
        // Validasi email
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
            Notification::route('mail', $umkm->email)
                ->notify(new UmkmApprovedNotification($umkm, $credentials));

            $successMessage = "UMKM '{$umkm->nama_usaha}' berhasil di-approve. " .
                "Kredensial telah dikirim ke email {$umkm->email}";

            $response = back()->with('success', $successMessage);

            if (app()->environment('local') && isset($credentials['password'])) {
                $response->with('dev_credentials', [
                    'email' => $umkm->email,
                    'password' => $credentials['password']
                ]);
            }

            return $response;
        } catch (\Exception $e) {
            \Log::error('UMKM Approval Error', [
                'umkm_id' => $umkm->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
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

    /**
     * Deactivate UMKM (set status to Nonaktif)
     */
    public function deactivate(Umkm $umkm)
    {
        $umkm->update(['status' => 'Nonaktif']);
        return back()->with('success', "UMKM '{$umkm->nama_usaha}' berhasil dinonaktifkan.");
    }

    /**
     * Activate UMKM (set status to Aktif)
     */
    public function activate(Umkm $umkm)
    {
        $umkm->update(['status' => 'Aktif']);
        return back()->with('success', "UMKM '{$umkm->nama_usaha}' berhasil diaktifkan kembali.");
    }

    /**
     * Reset Password for UMKM User (Useful for Dev/Admin recovery)
     */
    public function resetPassword(Umkm $umkm)
    {
        $user = $umkm->user;
        if (!$user) {
            return back()->with('error', 'UMKM ini belum memiliki akun User yang terhubung.');
        }

        $newPassword = $this->credentialService->generatePassword();
        
        $user->update([
            'password' => \Hash::make($newPassword)
        ]);

        $response = back()->with('success', "Password untuk UMKM '{$umkm->nama_usaha}' berhasil direset.");
        
        if (app()->environment('local')) {
            $response->with('dev_credentials', [
                'email' => $umkm->email,
                'password' => $newPassword
            ]);
        }

        return $response;
    }
}