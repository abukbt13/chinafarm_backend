<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectReturn extends Model
{
    protected $fillable = [
        'name',
        'description',
        'date',
        'amount',
        'farm_project_id',
        'user_id',
    ];

    // 🔁 Relationship: Expense belongs to a farming progress
    public function farmProject()
    {
        return $this->belongsTo(FarmProject::class);
    }

    // 🔁 Relationship: Expense belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
