<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = ['username', 'email', 'password', 'register_date', 'administrator', 'blocked', 'image'];

    protected $hidden = ['password'];

    protected $casts = [
        'administrator' => 'boolean',
        'blocked' => 'boolean',
        'register_date' => 'datetime',
    ];

    public static function create(array $attributes = []){
        $user = new User();

        $user->username = $attributes['username'];
        $user->email = $attributes['email'];
        $user->password = $attributes['password'];
        $user->image = 'default.png' ; //to be changed

        $user->save();
        return $user;
    }

}
