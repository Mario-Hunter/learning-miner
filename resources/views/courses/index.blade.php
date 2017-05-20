@extends('layouts.master')

@section('content')

@foreach($courses as $course)
	<div class="container row">
   		@include('courses.course')
   	</div>

   	<br>
   	<hr>
@endforeach

<div>
	@if($page < $limit)
		<a href="/courses/page/{{$page + 1}}" class="btn btn-primary">Next</a>
	@endif
	@if($page > 1)
		<a href="/courses/page/{{$page - 1}}" class="btn btn-primary">Previous</a>
	@endif
</div>

@stop
