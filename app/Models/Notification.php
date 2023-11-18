<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'notification';

    protected $fillable = ['content', 'date', 'read', 'id_user'];

    protected $hidden = [];

    protected $casts = [
        'read' => 'boolean',
        'date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
