<?php

namespace App\Models;

use App\Http\Controllers\FileController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public $timestamps = false;

    protected $fillable = ['username', 'email', 'password'];

    protected $hidden = ['password'];

    protected $casts = [
        'administrator' => 'boolean',
        'blocked' => 'boolean',
        'register_date' => 'datetime',
    ];

    public function userBadges() // TODO
    {
        return $this->hasMany(UserEarnsBadge::class, 'id_user');
    }

    public function badges()
    {
        return $this->belongsToMany(Badge::class, 'user_earns_badge', 'id_user', 'id_badge');
    }

    public function communities()
    {
        return $this->belongsToMany(Community::class, 'user_follows_community', 'id_user', 'id_community');
    }

    public function followedQuestions()
    {
        return $this->belongsToMany(Question::class, 'user_follows_question', 'id_user', 'id_question');
    }
}
