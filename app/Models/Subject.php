<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = ['user_id', 'name', 'color', 'exam_date', 'priority'];

public function user() 
    { 
        return $this->belongsTo(User::class); 
        }
public function tasks() 
    { 
        return $this->hasMany(Task::class); 
        }
public function studySessions() 
    { 
        return $this->hasMany(StudySession::class); 
        }
}
