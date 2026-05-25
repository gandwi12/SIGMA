<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'menu_id',
        'nama_user',
        'rating',
        'komentar',
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}