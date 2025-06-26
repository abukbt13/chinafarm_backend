<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FarmingSeason extends Model
{
    protected $fillable = [
        'crop',
        'start_date',
        'end_date',
        'description',
        'user_id'
    ];

}
