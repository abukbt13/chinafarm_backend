<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Milestone extends Model
{
    protected $fillable = [
        'date', 'description', 'pictures'
    ];

    protected $casts = [
        'pictures' => 'array', // so it's treated as an array in Laravel
    ];
}
