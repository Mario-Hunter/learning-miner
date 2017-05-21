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
        $filter = request('filterRank');
        $site = request('filterSite');
        if($filter == null)
        {
          if($site == null)
            return redirect("/search/$toSearch/1/0/no");
          else
            return redirect("/search/$toSearch/1/0/$site");
        } 
        else
        {
          if($site == null)
              return redirect("/search/$toSearch/1/$filter/no");
          else
            return redirect("/search/$toSearch/1/$filter/$site");
        }  
    }

    public function show($toSearch,$page,$filter,$site)
    {

      $courseNames = explode(' ',$toSearch);
      if($filter == 0){

        if($site == "no")
        {
            $coursesByName = Course::where(function($query) use ($courseNames){
              foreach($courseNames as $name){
                  $query->orwhere('name','LIKE','%'.$name.'%');
              }
          })->orderBy('searchRank');

          $courseByFullName = Course::where('name','LIKE','%'.$toSearch.'%')->orderBy('searchRank')->union($coursesByName)->get();
        }
        else
        {
            $coursesByName = Course::where(function($query) use ($courseNames){
              foreach($courseNames as $name){
                  $query->orwhere('name','LIKE','%'.$name.'%');
              }
          })->where('url','LIKE','%'.$site.'%')->orderBy('searchRank');

          $courseByFullName = Course::where('name','LIKE','%'.$toSearch.'%')->where('url','LIKE','%'.$site.'%')->orderBy('searchRank')->union($coursesByName)->get();
        }
        
      }
      else
      {
        if($site == "no")
        {
          $coursesByName = Course::where(function($query) use ($courseNames){
              foreach($courseNames as $name){
                  $query->orwhere('name','LIKE','%'.$name.'%');
              }
          })->where('rank','=',$filter)->orderBy('searchRank');

          $courseByFullName = Course::where('name','LIKE','%'.$toSearch.'%')->where('rank','=',$filter)->orderBy('searchRank')->union($coursesByName)->get();
        }
        else
        {
           $coursesByName = Course::where(function($query) use ($courseNames){
              foreach($courseNames as $name){
                  $query->orwhere('name','LIKE','%'.$name.'%');
              }
            })->where('url','LIKE','%'.$site.'%')->where('rank','=',$filter)->orderBy('searchRank');

            $courseByFullName = Course::where('name','LIKE','%'.$toSearch.'%')->where('url','LIKE','%'.$site.'%')->where('rank','=',$filter)->orderBy('searchRank')->union($coursesByName)->get();
        } 
      }
      
      $coursesByName = $courseByFullName;
      
      $tags = explode(' ',$toSearch);
      $tagEntry = Tag::whereIn('name',$tags)->get();
      $coursesByTags = array();



      if($filter == 0)
      {

        if($site == "no")
        {
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
        }
        else
        {
          if(count($tagEntry) != 0){
    
              $coursesByTags = Course::where(function($query) use ($tagEntry) {

              foreach ($tagEntry as $tag) {
                $tagCourses = $tag->courses()->get();
                foreach ($tagCourses as $tagCourse) {
                  $query->orwhere('name','=',$tagCourse->name);
                }
              }
            })->where('url','LIKE','%'.$site.'%')->orderBy('searchRank')->get();
          } 
        }  
      }
      else
      {
        if($site == "no")
        {
          if(count($tagEntry) != 0){
    
            $coursesByTags = Course::where(function($query) use ($tagEntry) {
              foreach ($tagEntry as $tag) {
                $tagCourses = $tag->courses()->get();
                foreach ($tagCourses as $tagCourse) {
                  $query->orwhere('name','=',$tagCourse->name);
                }
              }
            })->where('rank','=',$filter)->orderBy('searchRank')->get();
          } 
        }
        else
        {
          if(count($tagEntry) != 0){
    
            $coursesByTags = Course::where(function($query) use ($tagEntry) {
              foreach ($tagEntry as $tag) {
                $tagCourses = $tag->courses()->get();
                foreach ($tagCourses as $tagCourse) {
                  $query->orwhere('name','=',$tagCourse->name);
                }
              }
            })->where('url','LIKE','%'.$site.'%')->where('rank','=',$filter)->orderBy('searchRank')->get();
          } 
        }
        
      }
    
      $coursesByName = $this->toArray($coursesByName);
      $coursesByTags = $this->toArray($coursesByTags);
      $courses = array_unique(array_merge($coursesByName,$coursesByTags));
      $limit = ceil(count($courses) / 10.0);
      $courses = array_slice($courses, 10 * ($page - 1) , 10 * ($page), true);
      
      return view('search',compact('courses','toSearch','page','limit','filter','site'));
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