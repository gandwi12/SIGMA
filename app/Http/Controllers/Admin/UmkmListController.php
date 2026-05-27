<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Umkm;

class UmkmListController extends Controller
{
    public function pending()
    {
        $umkms = Umkm::where('status', 'pending')
            ->latest()
            ->get();

        return view('admin.umkm.pending', compact('umkms'));
    }

    public function approved()
    {
        $umkms = Umkm::where('status', 'Aktif')
            ->latest()
            ->get();

        return view('admin.umkm.approved', compact('umkms'));
    }
}