<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Umkm;

class UmkmSeeder extends Seeder
{
    public function run(): void
    {
        Umkm::create([
            'nama_usaha' => 'Warung Ibu Haji',
            'pemilik' => 'Ibu Haji Aminah',
            'kategori' => 'Makanan Tradisional',
            'lokasi' => 'Kebayoran Baru',
            'alamat' => 'Jl. Kenangan No.45, Kebayoran Baru, Jakarta Selatan',
            'whatsapp' => '6281234567890',
            'jam_operasional' => '09:00 - 21:00',
            'deskripsi' => 'Tradisi rasa yang tak tergerus zaman. Menyediakan makanan rumahan sehat dan ramah kantong mahasiswa.',
            'foto' => 'images/umkm/warung-ibu-haji.jpg',
            'rating' => 4.9,
            'status' => 'Aktif',
        ]);
    }
}