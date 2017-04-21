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
        $tags = explode(' ',$course);
        $coursesTags = array();
        $coursesNames = array();
        foreach($tags as $tag){
            $tagEntry = Tag::where('name',$tag)->get();
            if(count($tagEntry) != 0){
                $courses =$tagEntry[0]->courses()->orderBy('rank','desc')->get();
                array_push($coursesTags, $courses );
            }else{
                $courses = Course::where('name','LIKE','%'.$course.'%')->orderBy('rank','desc')->get();
                if(count($courses) != 0){
                    array_push($coursesNames,$courses);
                }
                
            }
        }



        return view('search',compact('coursesNames','coursesTags'));
    }
}
