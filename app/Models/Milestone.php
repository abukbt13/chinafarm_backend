<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Milestone extends Model
{
    protected $fillable = [
        'date', 'description','activity', 'pictures','farm_project_id','user_id'
    ];

    protected $casts = [
        'pictures' => 'array', // so it's treated as an array in Laravel
    ];
}
