<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Course;

class SearchController extends Controller
{


	public function set()
    {
    	$course = request('name');
		return redirect("/search/$course");	
    }

    public function show($course)
    {
		$courses = Course::where('name',$course)->get();
		return view('search',compact('courses'));	
    }
}
