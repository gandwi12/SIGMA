<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            CategorySeeder::class,
            UmkmSeeder::class,
            UserSeeder::class,
            MenuSeeder::class,
            ReviewSeeder::class,
        ]);
    }
}