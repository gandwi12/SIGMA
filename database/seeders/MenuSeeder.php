<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;
use App\Models\Umkm;
use App\Models\Category;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        $umkm = Umkm::first();

        $protein = Category::where('slug', 'tinggi-protein')->first();
        $rendah = Category::where('slug', 'rendah-kalori')->first();
        $hemat = Category::where('slug', 'paling-hemat')->first();
        $best = Category::where('slug', 'best-seller')->first();

        $menus = [
            [
                'umkm_id' => $umkm->id,
                'category_id' => $protein->id,
                'nama' => 'Nasi Ayam Sehat',
                'deskripsi' => 'Nasi hangat dengan ayam panggang berbumbu, sayuran segar, dan porsi protein tinggi.',
                'harga' => 15000,
                'kalori' => 450,
                'protein' => 30,
                'lemak' => 12,
                'karbo' => 55,
                'tag' => 'Tinggi Protein',
                'gambar' => 'images/menus/nasi-ayam.jpg',
                'rating' => 4.9,
                'jarak' => '0.5 km',
                'waktu' => '12 mnt',
                'status' => 'Aktif',
            ],
            [
                'umkm_id' => $umkm->id,
                'category_id' => $best->id,
                'nama' => 'Sate Maranggi Kantin Pusat',
                'deskripsi' => 'Sate maranggi empuk dengan sambal khas dan nasi hangat.',
                'harga' => 20000,
                'kalori' => 390,
                'protein' => 28,
                'lemak' => 10,
                'karbo' => 45,
                'tag' => 'Best Seller',
                'gambar' => 'images/menus/sate-maranggi.jpg',
                'rating' => 4.8,
                'jarak' => '0.7 km',
                'waktu' => '15 mnt',
                'status' => 'Aktif',
            ],
            [
                'umkm_id' => $umkm->id,
                'category_id' => $rendah->id,
                'nama' => 'Gado-Gado Ibu Enny',
                'deskripsi' => 'Sayuran rebus segar dengan bumbu kacang khas rumahan.',
                'harga' => 12000,
                'kalori' => 320,
                'protein' => 18,
                'lemak' => 8,
                'karbo' => 40,
                'tag' => 'Rendah Kalori',
                'gambar' => 'images/menus/gado-gado.jpg',
                'rating' => 4.7,
                'jarak' => '0.8 km',
                'waktu' => '15 mnt',
                'status' => 'Aktif',
            ],
            [
                'umkm_id' => $umkm->id,
                'category_id' => $hemat->id,
                'nama' => 'Bakso Malang Mahasiswa',
                'deskripsi' => 'Bakso hangat lengkap dengan pangsit dan tahu.',
                'harga' => 12000,
                'kalori' => 410,
                'protein' => 20,
                'lemak' => 13,
                'karbo' => 50,
                'tag' => 'Paling Hemat',
                'gambar' => 'images/menus/bakso.jpg',
                'rating' => 4.6,
                'jarak' => '1.0 km',
                'waktu' => '18 mnt',
                'status' => 'Aktif',
            ],
            [
                'umkm_id' => $umkm->id,
                'category_id' => $protein->id,
                'nama' => 'Ayam Bakar Pak Kumis',
                'deskripsi' => 'Ayam bakar bumbu manis pedas dengan lalapan segar.',
                'harga' => 20000,
                'kalori' => 480,
                'protein' => 35,
                'lemak' => 15,
                'karbo' => 50,
                'tag' => 'Tinggi Protein',
                'gambar' => 'images/menus/ayam-bakar.jpg',
                'rating' => 4.9,
                'jarak' => '0.5 km',
                'waktu' => '12 mnt',
                'status' => 'Aktif',
            ],
        ];

        foreach ($menus as $menu) {
            Menu::create($menu);
        }
    }
}