<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class FollowerController extends Controller
{
    public function follow(User $followedUser)
    {
    	$user = auth()->user();
    	$entry = $user->checkIffollowerExist($user,$followedUser);
    	$followers = DB::table('followers')
    	->where('user_id', '=', Auth::user()->id)
    	->where('user_followed_id', '=', $followedUser->id)
    	->first();
    	if (is_null($followers)) {
    		$newFollower=follower::create([
    			'user_id'=>$user->id,
    			'user_followed_id'=>$followedUser->id
    			]);
		}	
	 	else {
	 		
		}
    }
}
