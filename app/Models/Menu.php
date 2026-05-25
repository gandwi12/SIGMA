<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = [
        'umkm_id',
        'nama',
        'harga',
        'deskripsi',
        'tag',
        'kalori',
        'protein',
        'lemak',
        'status',
        'foto',
        'badge_1',
        'badge_2',
        'badge_3',
        'is_featured',
    ];

    public function umkm()
    {
        return $this->belongsTo(Umkm::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function getImageUrlAttribute()
    {
        if ($this->foto) {
            return asset('storage/' . $this->foto);
        }

        return asset('images/default-food.jpg');
    }
}