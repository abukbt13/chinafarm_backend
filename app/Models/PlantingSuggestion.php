<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlantingSuggestion extends Model
{
    protected $fillable = [
        'crop_name',
        'planting_month',
        'harvesting_month',
        'reason',
        'user_id',
        ];
}
