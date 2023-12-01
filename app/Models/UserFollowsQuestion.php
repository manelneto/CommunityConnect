<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserFollowsQuestion extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'user_follows_question';

    protected $primaryKey = ['id_user', 'id_question'];

    public $incrementing = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function question()
    {
        return $this->belongsTo(Question::class, 'id_question');
    }
}
