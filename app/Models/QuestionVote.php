<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionVote extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'question_vote';

    // Composite primary keys have some limitations in laravel
    protected $primaryKey = ['id_question', 'id_user'];

    // Disable auto-increment as we are using a composite primary key
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
