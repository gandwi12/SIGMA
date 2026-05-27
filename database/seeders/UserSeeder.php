<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Umkm;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $umkm = Umkm::first();

        if (!$umkm) {
            return;
        }

        User::updateOrCreate(
            ['email' => 'mitra@example.com'],
            [
                'name' => 'Mitra Default',
                'password' => Hash::make('  '),
                'role' => 'mitra',
                'umkm_id' => $umkm->id,
            ]
        );
    }
}
