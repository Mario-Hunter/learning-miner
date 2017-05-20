<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use Auth;
use App\follower;

class FollowerController extends Controller
{
    public function follow(User $user)
    {
       	$followingUser = auth()->user();
    	$followers = DB::table('followers')
    	->where('user_id', '=', Auth::user()->id)
    	->where('user_followed_id', '=', $user->id)
    	->first();
    	if (is_null($followers)) {
    		$newFollower=follower::create([
    			'user_id'=>$followingUser->id,
    			'user_followed_id'=>$user->id
    			]);

		}	
	 	else {}
		return view('users.show', compact('user'));
    }
}
