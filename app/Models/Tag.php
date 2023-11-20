<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'tag';

    public function questionTags()
    {
        return $this->hasMany(QuestionTag::class, 'id_tag');
    }
}
