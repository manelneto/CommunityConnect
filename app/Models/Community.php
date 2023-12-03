<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Community extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'community';

    public function users()
    {
        return $this->hasMany(UserFollowsCommunity::class, 'id_user');
    }
}
