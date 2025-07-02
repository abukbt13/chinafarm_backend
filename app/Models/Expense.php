<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    // ✅ Fields that can be mass-assigned
    protected $fillable = [
        'name',
        'description',
        'date',
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
