<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScannerResult extends Model
{
    protected $fillable = [
        'foto',
        'nama_makanan',
        'estimasi_kalori',
        'confidence',
        'deskripsi',
    ];
}