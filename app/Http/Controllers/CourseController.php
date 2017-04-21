<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Course;
use App\Tag;
use App\Rank;
use App\User;

class CourseController extends Controller
{

  public function __construct()
  {
    $this->middleware('auth',['except' => ['index','show']]);
  }

  public function index()
  {
    $courses = Course::latest()->get();

    return view('courses.index',compact('courses'));
  }

  public function create()
  {
    return view('courses.create');
  }


  public function store(){
  
  $this -> validate(request(),[

  'url' => 'required|url|unique:courses,url',
  'tags' => 'required',
  'name' =>'required'


  ]);
    
    $tags = explode(' ',request('tags'));

    $course = new Course(request(['url','name']));
 
    auth()->user()->publish($course);
    $course->insertTags($course,$tags);
    

    return redirect('/courses');
  }

  
  public function show(Course $course, User $user)
   {
     return view('courses.show',compact('course','user'));
   }

}
