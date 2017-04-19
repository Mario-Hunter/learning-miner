<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Course;
use App\Tag;

class SearchController extends Controller
{


	public function set()
    {   
        $this->validate(request(),[


          'name' =>'required'


          ]);

        $course = request('name');
        return redirect("/search/$course");	
    }

    public function show($course)
    {

        $tags = Tag::where('name',$course)->get();

        $coursesTags = $tags['0']->courses()->orderBy('rank','desc')->get();

        if($coursesTags == null)
        {
            $coursesNames = Course::where('name',$course)->orderBy('rank','desc')->get();
        }
        else
            $coursesNames = [];
        return view('search',compact('coursesNames','coursesTags'));
    }
}
