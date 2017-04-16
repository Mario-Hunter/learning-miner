@extends('layouts.master')

@section('content')


@foreach($coursesNames as $course)
	<div class="container row">
   		@include('courses.course')
   	</div>

   	<br>
   	<hr>
@endforeach



@foreach($coursesTags as $course)
	<div class="container row">
   		@include('courses.course')
   	</div>

   	<br>
   	<hr>
@endforeach


@stop