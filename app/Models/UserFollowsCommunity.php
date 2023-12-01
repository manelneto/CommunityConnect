<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserFollowsCommunity extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'user_follows_community';

    protected $primaryKey = ['id_user', 'id_community'];

    public $incrementing = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function community()
    {
        return $this->belongsTo(Community::class, 'id_community');
    }
}
