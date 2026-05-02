<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    protected $fillable = ['user_id', 'daily_hours', 'streak_count', 'last_studied_date'];

    public function user() 
        { return $this->belongsTo(User::class);
        }
}
