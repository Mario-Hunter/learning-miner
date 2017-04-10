@extends('layouts.master')

@section('content')

@foreach($courses as $course)
	<div class="container row">
   		@include('courses.course')
   	</div>

   	<br>
   	<hr>
@endforeach

@stop