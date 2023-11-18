<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'answer';

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function question()
    {
        return $this->belongsTo(Question::class, 'id_question');
    }

    public function votes()
    {
        return $this->hasMany(AnswerVote::class, 'id_answer');
    }

    public function likes()
    {
        return $this->votes()->where('likes', true);
    }

    public function dislikes()
    {
        return $this->votes()->where('likes', false);
    }
}
