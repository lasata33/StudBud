<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudySession extends Model
{
    protected $fillable = ['user_id', 'subject_id', 'date', 'duration_mins', 'session_type'];

    public function subject() 
    { 
        return $this->belongsTo(Subject::class); 
        }
    public function user() 
    { 
        return $this->belongsTo(User::class); 
        }
}
