<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserEarnsBadge extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'user_earns_badge';

    protected $primaryKey = ['id_user', 'id_badge'];

    public $incrementing = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function badge()
    {
        return $this->belongsTo(Badge::class, 'id_badge');
    }
}
