@extends('layouts.master')

@section('content')

<div class="container">
	<div class="row">
		@include('courses.course')	
	</div>
	<div class="row">
		<div class="col-md-12 text-center">
			<br>
			<a class="btn btn-info active" href="" role="button">Previous</a>
			<a class="btn btn-info active" href="" role="button">Next</a>
		</div>	
	</div>
</div>



