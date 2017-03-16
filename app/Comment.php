<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable =["body","course_id","user_id"];

    
    public function course(){
    	return $this->belongsto(Course::class);
    }
    public function user(){
    	return $this->belongsTo(User::class);
    }
}
