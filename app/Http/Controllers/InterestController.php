<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Course;
use App\Auth;
use App\User;
use App\Interest;
use App\ActivityLog;

class InterestController extends Controller
{
    
	//use xor
	public function store(Course $course)
	{
		$user = auth()->user();
		$entry = $user->checkIfInterestExist($user,$course);
		if(!$entry)
		{
			$entry = new Interest();
			$entry->course_id = $course->id;
			$entry->user_id = $user->id;
			$entry->interest = 1;
			$entry->save();
		}
		$log = ActivityLog::create(['user_id'=>$user->id,
            'course_id'=>$course->id,
            'action_type'=>"interest",
            'action_body'=>"1"
            ]);
        

		return redirect('/courses');
	}

	public function index()
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
		
		return view('courses.interest', compact('courses'));
	}

}
