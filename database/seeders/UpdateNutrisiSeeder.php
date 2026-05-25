<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;

/**
 * Seeder untuk mengupdate kandungan nutrisi menu agar valid
 * sesuai data referensi dari nilaigizi.com & sumber terpercaya (per porsi).
 */
class UpdateNutrisiSeeder extends Seeder
{
    public function run(): void
    {
        $updates = [
            // Nasi + Ayam Panggang ~300g
            // Ref: nasi putih 150g (270kcal, 4.5g protein, 0.5g lemak)
            //    + ayam panggang 150g (~150kcal, 30g protein, 8.5g lemak)
            'Nasi Ayam Sehat' => [
                'kalori'  => 420,
                'protein' => 35,
                'lemak'   => 9,
                'karbo'   => 44,
            ],

            // Sate Maranggi 10 tusuk daging sapi ~200g
            // Ref: halodoc.com / kelasfitness.com
            'Sate Maranggi Kantin Pusat' => [
                'kalori'  => 480,
                'protein' => 42,
                'lemak'   => 22,
                'karbo'   => 18,
            ],

            // Gado-gado sayuran + bumbu kacang + lontong ~300g
            // Ref: halodoc.com / nutriscan.app
            'Gado-Gado Ibu Enny' => [
                'kalori'  => 310,
                'protein' => 13,
                'lemak'   => 17,
                'karbo'   => 38,
            ],

            // Bakso + kuah + mie/bihun, porsi warung sedang
            // Ref: hellosehat.com (porsi sedang, bukan full lengkap)
            'Bakso Malang Mahasiswa' => [
                'kalori'  => 380,
                'protein' => 22,
                'lemak'   => 14,
                'karbo'   => 42,
            ],

            // Ayam bakar 200g + nasi + lalapan
            // Ref: halodoc.com / kumparan.com
            'Ayam Bakar Pak Kumis' => [
                'kalori'  => 470,
                'protein' => 38,
                'lemak'   => 16,
                'karbo'   => 46,
            ],
        ];

        foreach ($updates as $nama => $gizi) {
            $updated = Menu::where('nama', $nama)->update($gizi);
            $this->command->info("Updated [{$nama}]: kalori={$gizi['kalori']}, protein={$gizi['protein']}g, lemak={$gizi['lemak']}g — {$updated} row(s)");
        }

        $this->command->info('✅ Semua kandungan nutrisi berhasil diperbarui!');
    }
}
