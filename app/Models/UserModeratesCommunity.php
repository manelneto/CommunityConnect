<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserModeratesCommunity extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'user_moderates_community';

    // Composite primary keys have some limitations in laravel
    protected $primaryKey = ['id_user', 'id_community'];

    // Disable auto-increment as we are using a composite primary key
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
