<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Orders extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'user_id',
        'product_id',
        'quantity',
        'to_address',
        'phone',
        'email',
        'pay_by',
        'deli_time',
        'deli_status',
        'total_money',
        
    ];

    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }

    public function user()
    {
        return $this->belongsTo(Auth::user(), 'user_id');
    }
}
