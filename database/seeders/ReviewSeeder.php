<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;
use App\Models\Review;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $menu = Menu::first();

        Review::create([
            'menu_id' => $menu->id,
            'nama_user' => 'Mahasiswa Kampus A',
            'rating' => 5.0,
            'komentar' => 'Rasanya enak, porsinya pas, dan cocok buat makan siang hemat.',
        ]);

        Review::create([
            'menu_id' => $menu->id,
            'nama_user' => 'Anak Kos',
            'rating' => 4.8,
            'komentar' => 'Protein tinggi dan harganya masih masuk budget mahasiswa.',
        ]);
    }
}