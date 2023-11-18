<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnswerVote extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'answer_vote';

    protected $primaryKey = ['id_answer', 'id_user'];

    public $incrementing = false;

    public function answer()
    {
        return $this->belongsTo(Answer::class, 'id_answer');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
