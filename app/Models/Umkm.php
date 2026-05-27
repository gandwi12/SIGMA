<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Umkm extends Model
{
    protected $fillable = [
        'nama_usaha',
        'pemilik',
        'kategori',
        'lokasi',
        'alamat',
        'whatsapp',
        'email',
        'jam_operasional',
        'deskripsi',
        'foto',
        'rating',
        'status',
        'catatan_admin',
        'sejarah_judul',
        'sejarah_deskripsi',
        'filosofi_1_judul',
        'filosofi_1_deskripsi',
        'filosofi_2_judul',
        'filosofi_2_deskripsi',
        'filosofi_3_judul',
        'filosofi_3_deskripsi',
        'stat_1_value',
        'stat_1_label',
        'stat_2_value',
        'stat_2_label',
        'stat_3_value',
        'stat_3_label',
        'fasilitas_1',
        'fasilitas_2',
        'fasilitas_3',
    ];

    // ✨ Tambah relasi ke User
    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function menus()
    {
        return $this->hasMany(Menu::class);
    }

    public function photos()
    {
        return $this->hasMany(UmkmPhoto::class);
    }

    // Accessor untuk image_url
    public function getImageUrlAttribute()
    {
        if ($this->foto) {
            return asset('storage/' . $this->foto);
        }

        return asset('images/default-umkm.jpg');
    }
}