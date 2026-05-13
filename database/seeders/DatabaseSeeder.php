<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $umkm1 = \App\Models\Umkm::create([
            'name' => 'Warung Bu Sri',
            'description' => 'Spesialis masakan rumah sehat dengan bumbu minimalis namun kaya rasa.',
            'icon' => 'storefront'
        ]);

        $umkm2 = \App\Models\Umkm::create([
            'name' => 'Kedai Protein Tinggi',
            'description' => 'Fokus pada menu olahan ayam dan tempe untuk kebutuhan nutrisi atlet mahasiswa.',
            'icon' => 'verified'
        ]);

        $umkm3 = \App\Models\Umkm::create([
            'name' => 'Dapur Hijau Kampus',
            'description' => 'Menyediakan pilihan sayuran organik dan kebun mahasiswa binaan.',
            'icon' => 'eco'
        ]);

        \App\Models\Menu::create([
            'umkm_id' => $umkm1->id,
            'name' => 'Nasi Ayam Geprek Sigmaboy',
            'description' => 'Ayam geprek dengan sambal bawang otentik, disajikan dengan nasi hangat dan lalapan segar.',
            'price' => 15000,
            'calories' => 450,
            'protein' => 28,
            'is_recommendation' => true,
            'is_popular' => true,
            'category' => 'tinggi-protein',
            'image_path' => '/images/ayam-geprek.jpg'
        ]);

        \App\Models\Menu::create([
            'umkm_id' => $umkm2->id,
            'name' => 'Sate Maranggi Kantin Pusat',
            'description' => 'Sate sapi empuk bumbu maranggi khas purwakarta.',
            'price' => 20000,
            'calories' => 380,
            'protein' => 22,
            'available_time' => '10:00 - 15:00',
            'is_recommendation' => true,
            'is_popular' => true,
            'category' => 'tinggi-protein',
            'image_path' => '/images/sate-maranggi.jpg'
        ]);

        \App\Models\Menu::create([
            'umkm_id' => $umkm1->id,
            'name' => 'Bakso Malang Mahasiswa',
            'description' => 'Bakso urat dengan kuah kaldu sapi asli, kenyal dan gurih.',
            'price' => 12000,
            'calories' => 320,
            'protein' => 12,
            'is_popular' => true,
            'category' => 'sehat',
            'image_path' => '/images/bakso.jpg'
        ]);

        \App\Models\Menu::create([
            'umkm_id' => $umkm3->id,
            'name' => 'Oseng Tempeh & Kangkung',
            'description' => 'Oseng tempe pedas manis dengan kangkung segar pilihan.',
            'price' => 8000,
            'calories' => 215,
            'protein' => 15,
            'is_popular' => true,
            'category' => 'hemat',
            'image_path' => '/images/tempe.jpg'
        ]);

        \App\Models\Menu::create([
            'umkm_id' => $umkm3->id,
            'name' => 'Smoothie Bowl Pisang',
            'description' => 'Smoothie bowl segar dengan pisang, buah naga, dan biji chia.',
            'price' => 18000,
            'calories' => 300,
            'protein' => 4,
            'is_popular' => true,
            'category' => 'sehat',
            'image_path' => '/images/smoothie.jpg'
        ]);

        \App\Models\Menu::create([
            'umkm_id' => $umkm2->id,
            'name' => 'Aglio e Olio Hemat',
            'description' => 'Spaghetti aglio e olio dengan saus bawang putih dan olive oil aromatik.',
            'price' => 20000,
            'calories' => 450,
            'protein' => 10,
            'is_popular' => true,
            'category' => 'sehat',
            'image_path' => '/images/aglio-olio.jpg'
        ]);
    }
}
