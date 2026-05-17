<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'calories',
        'category',
        'taste_profile',
        'image_url',
    ];
}
