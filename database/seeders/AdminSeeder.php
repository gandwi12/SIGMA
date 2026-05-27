<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@sigma.com'],
            [
                'name' => 'Admin SIGMA',
                'password' => Hash::make('admin123456'),
                'role' => 'admin_sigma',
                'umkm_id' => null,
            ]
        );
    }
}
