<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserFollowsTag extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'user_follows_tag';

    protected $primaryKey = ['id_user', 'id_tag'];

    public $incrementing = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function tag()
    {
        return $this->belongsTo(Tag::class, 'id_tag');
    }
}
