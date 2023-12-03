<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'question';

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function community()
    {
        return $this->belongsTo(Community::class, 'id_community');
    }

    public function votes()
    {
        return $this->hasMany(QuestionVote::class, 'id_question');
    }

    public function comments()
    {
        return $this->hasMany(QuestionComment::class, 'id_question');
    }

    public function answers()
    {
        return $this->hasMany(Answer::class, 'id_question');
    }

    public function likes()
    {
        return $this->votes()->where('likes', true);
    }

    public function dislikes()
    {
        return $this->votes()->where('likes', false);
    }

    public function questionTags()
    {
        return $this->hasMany(QuestionTag::class, 'id_question');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'question_tags', 'id_question', 'id_tag');
    }
}
