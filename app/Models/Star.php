<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Star extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'star_number'
    ];

    public function user()
    {
        return $this->belongsTo(Auth::user(), 'user_id');
    }

    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }

    public function scopeUserStarProduct($query, $id)
    {
        return $query->where('user_id', Auth::user()->id)->where('product_id', $id);
    }
}
