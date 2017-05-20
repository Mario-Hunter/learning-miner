<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Course;
use App\Auth;
use App\User;
use App\Interest;
use App\ActivityLog;
use Illuminate\Support\Facades\Redirect;

class InterestController extends Controller
{
    
	public function setStoreDelete(Course $course)
	{
		$user = auth()->user();
		$entry = $user->checkIfInterestExist($user,$course);
		$valueOfIntrest = 1;
		if($entry)
		{
			$entry = Interest::where('course_id','=',$course->id)->delete();
			$valueOfIntrest = 0;
		}
		else
		{
			$entry = Interest::create([

					'course_id' => $course->id,
					'user_id' => $user->id,
					'interests' => 1
				]);
		}

		$log = ActivityLog::create(['user_id'=>$user->id,
            'course_id'=>$course->id,
            'action_type'=>"interest",
            'action_body'=> $valueOfIntrest
        ]);
        

		return Redirect::back();
	}

	public function index($page)
	{
		$user = auth()->user();
		$interests = $user->interest()->get();
		$coursesCollection = array();
		foreach ($interests as $interest) {
			array_push($coursesCollection, $interest->course()->get());
		}
		$courses = array();
		foreach($coursesCollection as $courseCollection)
		{
			array_push($courses, $courseCollection[0]);
		}
		
		$limit = ceil(count($courses) / 10.0);
        $courses = array_slice($courses, 10 * ($page - 1) , 10 * ($page), true);

		return view('courses.interest', compact('courses','page','limit'));
	}

}
