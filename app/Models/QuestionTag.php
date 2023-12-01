<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionTag extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'question_tags'; 

    protected $primaryKey = ['id_question', 'id_tag'];

    public $incrementing = false;

    public function question()
    {
        return $this->belongsTo(Question::class, 'id_question');
    }

    public function tag()
    {
        return $this->belongsTo(Tag::class, 'id_tag');
    }
}
