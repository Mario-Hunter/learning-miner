@extends('layouts.master')

@section('content')

	
	@foreach($courses as $course)
		<div  class="conatiner row">
			@include('courses.course')
		</div>
		<br>
		<hr>
	@endforeach
@stop
