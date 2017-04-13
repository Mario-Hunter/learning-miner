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

    public function addRank($value)
    {
        
        $this->rank()->create([
                    'rank' => $value,
                    'course_id' => $this->id,
                    'user_id' => auth()->id()
            ]);
        $this->rankModifier($value);
    }

    public function rankModifier($value)
    {
        $rankCourse = $this->rank;
        $rankCourse += $value;
        $this->rank = $rankCourse;
        $this->save();
    }

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function tags(){
        return $this->belongsToMany(Tag::class);
    }

    public function rank()
    {
        return $this->hasMany(Rank::class);
    }
}
