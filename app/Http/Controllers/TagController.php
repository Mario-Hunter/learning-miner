<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tag;

class TagController extends Controller
{
    public function index(Tag $tag){
    	$courses = $tag->courses;

    	return view('courses.index',compact('courses'));
    }
}
