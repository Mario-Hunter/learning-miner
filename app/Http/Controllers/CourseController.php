<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Course;
use App\Tag;
use App\Rank;
use App\User;
use Goutte\Client;
use Illuminate\Support\Facades\Auth;
use App\Events\CourseCreated;
use Illuminate\Support\Facades\Redirect;


class CourseController extends Controller
{

  public function __construct()
  {
    $this->middleware('auth',['except' => ['index','show']]);
  }

  public function index()
  {
    $user = auth()->user();
    if( $user && $user -> confirmed == '0'){


      Auth::logout();
      session()->flash('message','Your e-mail has not been verified yet. Please verify it then log in.');
      redirect('/courses');
    }
    $courses = Course::latest()->take(10)->get();
    $page = 1;
    $limit = Course::count();
    return view('courses.index',compact('courses','page','limit'));
  }

  
  public function indexPage($page)
  {
    $user = auth()->user();

    if( $user && $user -> confirmed == '0'){
      Auth::logout();
      session()->flash('message','Your e-mail has not been verified yet. Please verify it then log in.');
      redirect('/courses');
    }

    $limit = Course::count();
    $courses = Course::latest()->take(10)->offset(($page-1)*10)->get();

    return view('courses.index',compact('courses','page','limit'));
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

    $client = new Client();
    $crawler = $client -> request('GET',request('url'));
    try {
      $title = $crawler->filter('meta[property="og:title"]')->attr('content');
    } catch (\InvalidArgumentException $e) {
      $title = null;
    }
    try {
      $image_url = $crawler->filter('meta[property="og:image"]')->attr('content');
    } catch (\InvalidArgumentException $e) {
      $image_url = null;
    }
    try {
      $description = substr($crawler->filter('meta[property="og:description"]')->attr('content'),0,189)."..";
    } catch (\InvalidArgumentException $e) {
      $description = null;
    }
    $meta = [
    'title' => $title,
    'description' => $description,
    'image_url' => $image_url,
    ];
    $data = array_merge($meta,request(['url','name']));
    
    //dd($data);
    $course = new Course($data);

    

    auth()->user()->publish($course);
    
    $course->insertTags($course,$tags);

    auth()->user()->addScore(5); 


    event(new CourseCreated($course));


    return redirect('/courses');
  }

  
  public function show(Course $course, User $user)
  {
   return view('courses.show',compact('course','user'));
 }

 public function delete(Course $course){
  $course->delete();
  return Redirect::back();
 }

}
