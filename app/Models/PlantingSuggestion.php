<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlantingSuggestion extends Model
{
    protected $fillable = [
        'crop_name',
        'period',
        'factor',
        'user_id',
        ];
}
