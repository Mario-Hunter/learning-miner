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
	@if($page > 1)
		<a href="/search/{{$toSearch}}/{{$page-1}}/{{$filter}}/{{$site}}" class="btn btn-primary">Previous</a>
	@endif
	@if($page < $limit)
		<a href="/search/{{$toSearch}}/{{$page+1}}/{{$filter}}/{{$site}}" class="btn btn-primary">Next</a>
	@endif
</div>


@stop