<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use Auth;
use App\follower;
use App\Course;
use App\Events\Followed;

class FollowerController extends Controller
{
    public function follow(User $user)
    {
        $followingUser = auth()->user();
        $followers_query = DB::table('followers')
        ->where('user_id', '=', Auth::user()->id)
        ->where('user_followed_id', '=', $user->id);

        $followers= $followers_query->first();
        if (is_null($followers)) {
          $newFollower=follower::create([
             'user_id'=>$followingUser->id,
             'user_followed_id'=>$user->id
             ]);
          event(new Followed($followingUser,$user));
      }	
      else {
        $followers_query->delete();
    }
    return view('users.show', compact('user'));
}

public function followers(User $user)
{

    $followers = DB::table('followers')
    ->select(DB::raw("followers.id"))
    ->join('learning_miner.users','users.id','=','followers.user_followed_id')
    ->where('users.id',$user->id)
    ->get();
    $followersCollection = array();
    foreach ($followers as $follower) {

        $followerr = Follower::find($follower->id)->user()->get();
        array_push($followersCollection,$followerr);
    }

        //return view('courses.interest', compact('courses'));
}
public function following($page)
{
    $user=auth()->user();
    $following = $user->follower()->get();
    $following_users = array();
    foreach ($following as $following_user){
        $followingg = DB::table('followers')
        ->where('user_id', '=', $user->id)
        ->where('user_followed_id', '=', $following_user->user_followed_id)
        ->first();
        $userr = DB::table('users')
        ->where('id', '=',$followingg->user_followed_id)
        ->first();
        array_push($following_users,$userr);

    }

    $courses= array();
    if(count($following_users)!=0){
        $courses = Course::where(function($query) use ($following_users){
         foreach($following_users as $fuser){
            $query->orwhere('user_id',$fuser->id);
        }
    })->get();
    }

    $limit = ceil(count($courses) / 10.0);

    if(count($courses) > 0 ){
        
        $courses = array_slice($courses->getIterator()->getArrayCopy(), 10 * ($page - 1) , 10 * ($page),true);
    }
    return view('courses.homecourses', compact('courses','page','limit'));
}


}
