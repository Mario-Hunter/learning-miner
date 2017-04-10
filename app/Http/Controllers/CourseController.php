<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Course;

class CourseController extends Controller
{

 public function __construct()
 {
    $this->middleware('auth',['except' => ['index','show']]);
}
public function index(){
   $courses = Course::latest()
   ->get();

   return view('courses.index',compact('courses'));
}


public function create(){
   return view('courses.create');
}

public function store(){
   $this -> validate(request(),[
      'url' => 'required',
      'tags' => 'required',
      'name' =>'required'


      ]);

   auth()->user()->publish(
     new Course(request(['url','name']))

     );

   return redirect('/courses');

}



public function show(Course $course){
   return view('course.show',compact('course'));
}

}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Course;

class CourseController extends Controller
{

 public function __construct()
 {
    $this->middleware('auth',['except' => ['index','show']]);
}
public function index(){
   $courses = Course::latest()
   ->get();

   return view('courses.index',compact('courses'));
}


public function create(){
   return view('courses.create');
}

public function store(){
   $this -> validate(request(),[
      'url' => 'required',
      'tags' => 'required',
      'name' =>'required'


      ]);

   auth()->user()->publish(
     new Course(request(['url','name']))

     );

   return redirect('/courses');

}



public function show(Course $course){
   return view('course.show',compact('course'));
}

}
