<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;
use App\User;

class follower extends Model
{
	protected $fillable = ["user_id", "user_followed_id"];

    public function user()
	{
		return $this->belongsTo(User::class);
	}

	 public static function ifFollowingExists(User $user)
    {
        $followingUser = auth()->user();
        $followers_query = DB::table('followers')
        ->where('user_id', '=', Auth::user()->id)
        ->where('user_followed_id', '=', $user->id);
        
        $followers= $followers_query->first();
        if (is_null($followers)) {
            return false;
        }   
        else
        {
            return true;
        }
    }
}
