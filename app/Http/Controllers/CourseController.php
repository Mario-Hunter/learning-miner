<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Course;

class CourseController extends Controller
{
    public function index(){
    	$courses = Course::latest()
    	->get();

    	return view('courses.index');
    }


    public function create(){
    	return view('courses.create');
    }

    public function store(){
    	$this -> validate(request(),[
    		'url' => 'required',
    		'tags' => 'required'


    		]);

    	auth()->user()->publish(
    			new Course(request(['url','tags']))

    		);

    	return redirect('/courses');

    }

    public function show(Course $course){
    	return view('course.show',compact('course'));
    }

}
