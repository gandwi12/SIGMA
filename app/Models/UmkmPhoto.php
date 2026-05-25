<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class UmkmPhoto extends Model
{
    use HasFactory;

    protected $fillable = [
        'umkm_id',
        'foto',
    ];

    public function umkm()
    {
        return $this->belongsTo(Umkm::class);
    }

    public function getImageUrlAttribute()
    {
        return Storage::url($this->foto);
    }
}