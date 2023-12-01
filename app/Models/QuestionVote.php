<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionVote extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'question_vote';

    protected $primaryKey = ['id_question', 'id_user'];

    public $incrementing = false;

    public function question()
    {
        return $this->belongsTo(Question::class, 'id_question');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
