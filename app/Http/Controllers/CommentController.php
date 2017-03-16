<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use App\Course;

class CommentController extends Controller
{
   	public function store(Course $course){
   		$this->validate(request(),['body' => 'required|min:2']);

    	$course->addComent(request('body'));

    	return back();
   	}
}
