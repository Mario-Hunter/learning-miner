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

        $toSearch = request('name');
        return redirect("/search/$toSearch/1");	
    }

    public function show($toSearch,$page)
    {


      $courseByFullName = Course::where('name','LIKE','%'.$toSearch.'%')->orderBy('searchRank');

      $courseNames = explode(' ',$toSearch);
      $coursesByName = Course::where(function($query) use ($courseNames){
              foreach($courseNames as $name){
                  $query->orwhere('name','LIKE','%'.$name.'%');
              }
      })->orderBy('searchRank')->union($courseByFullName)->get();


      $tags = explode(' ',$toSearch);
      $tagEntry = Tag::whereIn('name',$tags)->get();
      $coursesByTags = array();
      if(count($tagEntry) != 0){
    
        $coursesByTags = Course::where(function($query) use ($tagEntry) {

          foreach ($tagEntry as $tag) {
            $tagCourses = $tag->courses()->get();
            foreach ($tagCourses as $tagCourse) {
              $query->orwhere('name','=',$tagCourse->name);
            }
          }
        })->orderBy('searchRank')->get();
      } 

      $coursesByName = $this->toArray($coursesByName);
      $coursesByTags = $this->toArray($coursesByTags);
      $courses = array_unique(array_merge($coursesByName,$coursesByTags));
      $limit = ceil(count($courses) / 10.0);
      $courses = array_slice($courses, 10 * ($page - 1) , 10 * ($page), true);
      
      return view('search',compact('courses','toSearch','page','limit'));
   }

   private function toArray($collection)
   {
      $transArray = array();
      foreach ($collection as $element) {
        array_push($transArray, $element);
      }

      return $transArray;
   }
}