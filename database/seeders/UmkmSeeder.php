<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Umkm;

class UmkmSeeder extends Seeder
{
    public function run(): void
    {
        $umkms = [
            [
                'nama_usaha' => 'Warung Ibu Haji',
                'pemilik' => 'Ibu Haji Aminah',
                'kategori' => 'Makanan Saja',
                'lokasi' => 'Kebayoran Baru',
                'alamat' => 'Jl. Kenangan No.45, Kebayoran Baru, Jakarta Selatan',
                'whatsapp' => '6281234567890',
                'jam_operasional' => '09:00 - 21:00',
                'deskripsi' => 'Tradisi rasa yang tak tergerus zaman. Menyediakan makanan rumahan sehat dan ramah kantong mahasiswa.',
                'foto' => 'images/umkm/warung-ibu-haji.jpg',
                'rating' => 4.9,
                'status' => 'Aktif',
            ],
            [
                'nama_usaha' => 'Bakso Bude Sari',
                'pemilik' => 'Bude Sari',
                'kategori' => 'Makanan Saja',
                'lokasi' => 'Cibubur',
                'alamat' => 'Jl. Melati No.12, Cibubur, Jakarta Timur',
                'whatsapp' => '6281133344455',
                'jam_operasional' => '10:00 - 22:00',
                'deskripsi' => 'Bakso empuk dan kuah gurih dengan racikan rempah otentik.',
                'foto' => 'images/umkm/bakso-bude-sari.jpg',
                'rating' => 4.8,
                'status' => 'Aktif',
            ],
            [
                'nama_usaha' => 'Kopi Kaki Lima',
                'pemilik' => 'Pak Dedi',
                'kategori' => 'Makanan dan Minuman',
                'lokasi' => 'Depok',
                'alamat' => 'Jl. Nangka No.8, Depok',
                'whatsapp' => '628119998877',
                'jam_operasional' => '07:00 - 20:00',
                'deskripsi' => 'Kopi robusta lokal dan pastel renyah favorit para pelajar.',
                'foto' => 'images/umkm/kopi-kaki-lima.jpg',
                'rating' => 4.7,
                'status' => 'Aktif',
            ],
        ];

        foreach ($umkms as $data) {
            Umkm::updateOrCreate([
                'nama_usaha' => $data['nama_usaha'],
            ], $data);
        }
    }
}