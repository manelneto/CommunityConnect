<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public $timestamps  = false;

    protected $fillable = ['username', 'email', 'password'];

    protected $hidden = ['password'];

    protected $casts = [
        'administrator' => 'boolean',
        'blocked' => 'boolean',
        'register_date' => 'datetime',
    ];
}
