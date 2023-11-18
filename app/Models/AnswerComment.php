<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnswerComment extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'answer_comment';

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function answer()
    {
        return $this->belongsTo(Answer::class, 'id_answer');
    }
}
