<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Contacts extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'send_to',
        'user_id',
        'content',
        'type_of',
        'permission_id',
    ];

    public function user()
    {
        return $this->belongsTo(Auth::user(), 'user_id');
    }
}
