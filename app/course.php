<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = ['url','tags'];


    public function coments(){
    	return $this->hasMany(Comment::class);
    }


    public function user(){
    	return $this->belongsTo(User::class);
    }
}
