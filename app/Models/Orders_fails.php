<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders_fails extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'cancel_from_id',
        'cancel_reason',
        
    ];
}
