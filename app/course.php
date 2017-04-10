<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = ['url','tags','name'];


    public function comments()
    {
    	return $this->hasMany(Comment::class);
    }

    public function addComent($body)
    {
    	$this->comments()->create([
                                    'body' => $body,
                                    'course_id'=>$this->id,
                                    'user_id'=>auth()->id()
                                    ]);
    }

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function tags(){
        return $this->belongsToMany(Tag::class);
    }
}
