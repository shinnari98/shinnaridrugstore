<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'nickname',
        'email',
        'password',
        'phone',
        'address',
        'avatar'
    ];

    public function permission()
    {
        return $this->belongsTo(Permissions::class, 'permission_id');
    }

    public function likes()
    {
        return $this->hasMany(Likes::class, 'user_id');
    }
}