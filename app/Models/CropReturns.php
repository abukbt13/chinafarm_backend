<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CropReturns extends Model
{
    protected $fillable = [
        'name',
        'description',
        'date',
        'amount',
        'farming_progress_id',
        'user_id',
    ];

    // 🔁 Relationship: Expense belongs to a farming progress
    public function farmingProgress()
    {
        return $this->belongsTo(FarmingProgress::class);
    }

    // 🔁 Relationship: Expense belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
