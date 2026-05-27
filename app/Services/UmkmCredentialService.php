<?php

namespace App\Services;

use App\Models\User;
use App\Models\Umkm; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UmkmCredentialService
{
    /**
     * Generate unique username dari nama UMKM
     */
    public function generateUsername(string $namaBisnis): string
    {
        // Bersihkan nama: lowercase, hapus spasi, ambil 3-8 karakter
        $slug = Str::slug($namaBisnis);
        $baseUsername = substr($slug, 0, 8) ?: 'umkm';

        // Cek apakah username sudah ada
        $username = $baseUsername;
        $counter = 1;

        while (User::where('name', $username)->exists()) {
            $username = $baseUsername . $counter;
            $counter++;
        }

        return $username;
    }

    /**
     * Generate random password (8-12 karakter, mixed case, numbers, symbols)
     */
    public function generatePassword(): string
    {
        return Str::password(
            length: 12,
            letters: true,
            numbers: true,
            symbols: true
        );
    }

    /**
     * Create user account untuk UMKM yang di-approve
     */
    public function createUserForUmkm(Umkm $umkm): array
    {
        $password = $this->generatePassword();

        // Cek dulu apakah user dengan email ini sudah ada
        $existingUser = \App\Models\User::where('email', $umkm->email)->first();

        if ($existingUser) {
            // Kalau sudah ada, update saja linknya ke umkm ini
            $existingUser->update([
                'umkm_id' => $umkm->id,
                'role'    => 'mitra',
            ]);

            return [
                'user'     => $existingUser,
                'password' => null, // password tidak direset
            ];
        }

        $user = \App\Models\User::create([
            'name'     => $this->generateUsername($umkm->nama_usaha),
            'email'    => $umkm->email,
            'password' => bcrypt($password),
            'role'     => 'mitra',
            'umkm_id'  => $umkm->id,
        ]);

        return [
            'user'     => $user,
            'password' => $password,
        ];
    }
}