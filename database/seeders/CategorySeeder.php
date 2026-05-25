<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Semua', 'slug' => 'semua'],
            ['name' => 'Tinggi Protein', 'slug' => 'tinggi-protein'],
            ['name' => 'Rendah Kalori', 'slug' => 'rendah-kalori'],
            ['name' => 'Paling Hemat', 'slug' => 'paling-hemat'],
            ['name' => 'Best Seller', 'slug' => 'best-seller'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}