<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['subject_id', 'user_id', 'title', 'deadline', 'is_completed', 'estimated_mins'];

    public function subject() 
    { 
        return $this->belongsTo(Subject::class); 
        }
    public function user() 
    { 
        return $this->belongsTo(User::class); 
        }
}
