<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Course;

class CourseController extends Controller
{
<<<<<<< HEAD
=======

    public function __construct()
    {
        $this->middleware('auth')->except(['show', 'index']);
    }


    public function index()
    {
    	$courses = Course::latest()->get();
>>>>>>> refs/remotes/origin/master

    public function __construct()
    {
        $this->middleware('auth')->except(['show', 'index']);
    }


<<<<<<< HEAD
    public function index()
    {
      $courses = Course::latest()->get();

      return view('courses.index',compact('courses'));
    }


    public function create()
    {
      return view('courses.create');
    }

    public function store()
    {
      $this -> validate(request(),[
                                  'url' => 'required',
                                  'tags' => 'required',
                                  'name' =>'required'
                                    ]);

      auth()->user()->publish(new Course(request(['url','name'])));
=======
    public function create()
    {
    	return view('courses.create');
    }

    public function store()
    {
    	$this -> validate(request(),[
    		                          'url' => 'required',
    		                          'tags' => 'required',
    		                          'name' =>'required'
                                    ]);

    	auth()->user()->publish(new Course(request(['url','name'])));
>>>>>>> refs/remotes/origin/master

      return redirect('/courses');

    }

    public function show(Course $course)
    {
<<<<<<< HEAD
      return view('courses.show',compact('course'));
=======
    	return view('courses.show',compact('course'));
>>>>>>> refs/remotes/origin/master
    }

}
