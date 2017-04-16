<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Course;
use App\Tag;

class SearchController extends Controller
{


	public function set()
    {
    	$course = request('name');
		return redirect("/search/$course");	
    }

    public function show($course)
    {
		
        $tags = Tag::where('name',$course)->get();

        $coursesTags = $tags['0']->courses()->get();

        if($coursesTags == null)
        {
            $coursesNames = Course::where('name',$course)->get();
        }
        else
            $coursesNames = [];
        return view('search',compact('coursesNames','coursesTags'));
    }
}
