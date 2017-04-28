<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rank extends Model
{
    
	protected $fillable = ["rank", "course_id", "user_id"];

	public function course()
	{
		return $this->belongsTo(Course::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	

}
