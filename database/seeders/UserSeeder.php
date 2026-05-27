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
        $umkms = Umkm::where('status', 'Aktif')->get();

        if ($umkms->isEmpty()) {
            return;
        }

        $accounts = [
            [
                'email' => 'mitra1@example.com',
                'name' => 'Mitra Ibu Haji',
            ],
            [
                'email' => 'mitra2@example.com',
                'name' => 'Mitra Bude Sari',
            ],
            [
                'email' => 'mitra3@example.com',
                'name' => 'Mitra Kopi Kaki Lima',
            ],
        ];

        foreach ($umkms as $index => $umkm) {
            if (!isset($accounts[$index])) {
                break;
            }

            User::updateOrCreate(
                ['email' => $accounts[$index]['email']],
                [
                    'name' => $accounts[$index]['name'],
                    'password' => Hash::make('password123'),
                    'role' => 'mitra',
                    'umkm_id' => $umkm->id,
                ]
            );
        }
    }
}
