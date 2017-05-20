 @extends('layouts.master')

@section('content')

<div class="container">
	<div class="row">
	
		@include('courses.course')

	</div>
	<div class="row">
		<div class="col-md-12 text-center">
			<br>

		
			@if($course->buttonCases() == 1)
				<a class="btn btn-info active" href="/courses/{{($course->id ) - 1}}" role="button">Previous</a>
				<a class="btn btn-info active" href="/courses/{{($course->id ) + 1}}" role="button">Next</a>
			@elseif($course->buttonCases() == 2)
				<a class="btn btn-info active" href="/courses/{{($course->id ) - 1}}" role="button">Previous</a>
			@elseif($course->buttonCases() == 3)
				<a class="btn btn-info active" href="/courses/{{($course->id ) + 1}}" role="button">Next</a>
			@else
			@endif
		
		</div>
	</div>
</div>


