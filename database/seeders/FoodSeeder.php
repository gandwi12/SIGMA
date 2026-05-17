<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FoodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $foods = [
            [
                'name' => 'Nasi Goreng Spesial',
                'description' => 'Nasi goreng gurih dengan telur, ayam, dan sayuran.',
                'price' => 25000,
                'calories' => 500,
                'category' => 'Heavy Meal',
                'taste_profile' => 'Savory',
                'image_url' => 'https://via.placeholder.com/150',
            ],
            [
                'name' => 'Salad Buah Segar',
                'description' => 'Campuran buah-buahan segar dengan saus yogurt rendah kalori.',
                'price' => 20000,
                'calories' => 150,
                'category' => 'Snack',
                'taste_profile' => 'Sweet',
                'image_url' => 'https://via.placeholder.com/150',
            ],
            [
                'name' => 'Ayam Geprek Pedas',
                'description' => 'Ayam goreng tepung digeprek dengan sambal bawang super pedas.',
                'price' => 22000,
                'calories' => 600,
                'category' => 'Heavy Meal',
                'taste_profile' => 'Spicy',
                'image_url' => 'https://via.placeholder.com/150',
            ],
            [
                'name' => 'Smoothie Bowl Mangga',
                'description' => 'Smoothie mangga manis dengan topping granola dan chia seed.',
                'price' => 30000,
                'calories' => 300,
                'category' => 'Dessert',
                'taste_profile' => 'Sweet',
                'image_url' => 'https://via.placeholder.com/150',
            ],
            [
                'name' => 'Mie Goreng Seafood',
                'description' => 'Mie goreng dengan bumbu gurih manis dan topping udang cumi.',
                'price' => 28000,
                'calories' => 550,
                'category' => 'Heavy Meal',
                'taste_profile' => 'Savory',
                'image_url' => 'https://via.placeholder.com/150',
            ],
        ];

        foreach ($foods as $food) {
            \App\Models\Food::create($food);
        }
    }
}
