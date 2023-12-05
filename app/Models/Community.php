<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Community extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'community';

    public function users() // followers
    {
        return $this->hasMany(UserFollowsCommunity::class, 'id_community');
    }

    public function participants()
    {
        return $this->belongsToMany(User::class, 'reputation', 'id_community', 'id_user')->withPivot('rating', 'expert');
    }
}
