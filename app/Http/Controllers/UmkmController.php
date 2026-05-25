<?php

namespace App\Http\Controllers;

use App\Models\Umkm;
use App\Models\UmkmPhoto;
use Illuminate\Http\Request;

class UmkmController extends Controller
{
    public function create()
    {
        return view('pages.daftar-umkm');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_usaha' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'lokasi' => 'nullable|string|max:255',
            'alamat' => 'required|string',
            'whatsapp' => 'required|string|max:30',
            'jam_operasional' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'fotos' => 'nullable|array|max:10',
            'fotos.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $fotoUtama = null;

        if ($request->hasFile('fotos')) {
            $fotoUtama = $request->file('fotos')[0]->store('umkm', 'public');
        }

        $umkm = Umkm::create([
            'nama_usaha' => $data['nama_usaha'],
            'kategori' => $data['kategori'],
            'lokasi' => $data['lokasi'] ?? '-',
            'alamat' => $data['alamat'],
            'whatsapp' => $data['whatsapp'],
            'jam_operasional' => $data['jam_operasional'],
            'deskripsi' => $data['deskripsi'],
            'foto' => $fotoUtama,
            'status' => 'pending',
        ]);

        if ($request->hasFile('fotos')) {
            foreach ($request->file('fotos') as $foto) {
                UmkmPhoto::create([
                    'umkm_id' => $umkm->id,
                    'foto' => $foto->store('umkm/photos', 'public'),
                ]);
            }
        }

        return redirect()
            ->route('umkm.create')
            ->with('success', 'Pendaftaran UMKM berhasil dikirim. Menunggu persetujuan admin.');
    }

    public function show(Umkm $umkm)
    {
        if (!in_array($umkm->status, ['Aktif', 'aktif', 'approved'])) {
            abort(404);
        }

        $umkm->load(['menus', 'photos']);

        return view('pages.profil-umkm', compact('umkm'));
    }
}