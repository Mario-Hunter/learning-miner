<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class follower extends Model
{
	protected $fillable = ["user_id", "user_followed_id"];

    public function user()
	{
		return $this->belongsTo(User::class);
	}
}
