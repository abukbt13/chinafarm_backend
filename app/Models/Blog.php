<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;

class Blog extends Model
{
    use HasFactory;
    public function getHashIdAttribute()
    {
        return Hashids::encode($this->id);
    }
    protected $appends = ['hash_id'];

    protected $fillable = ['user_id', 'title', 'summary', 'content', 'image'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }}
