<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'date',
        'amount',
        'farm_project_id',
        'user_id',
    ];

    // 🔁 Relationship: Expense belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
