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

    public function username(){
        return $this->username;
    }
    public function email(){
        return $this->email;
    }
    public function password(){
        return $this->password;
    }
    public function register_date(){
        return $this->register_date;
    }
    public function administrator(){
        return $this->administrator;
    }
    public function blocked(){
        return $this->blocked;
    }
    public function image(){
        return $this->image;
    }
}
