@extends('layouts.master')

@section('content')

<div class="col-sm-7 col-sm-offset-1 blog-sidebar">

	<h1> Publish a course </h1>
	<hr>

	<form method = "POST" action="/courses">
	
		{{csrf_field()}}

		<div class="form-group">
			<label for="name">Name:</label>
			<input type="text" class="form-control" id="name"  name="name"  required>
		</div>

		<div class="form-group">
			<label for="URL">URL:</label>
			<input type="text" class="form-control" id="url"  name="url" required>
		</div>

		<div class="form-group">
			<label for="tags">Tags</label>
			<input id="tags" name = "tags" class ="form-control" required></input>
		</div>

		<div class = 'class form-group'>
			<button type="submit" class="btn btn-primary">Publish</button>
		</div>

	</form>
</div>
@stop