@extends('layouts.app')



@section('content')

<div class="col-sm-7 col-sm-offset-1 blog-sidebar">

	<h1> Publish a course </h1>
	<hr>

	<form method = "POST" action="/courses">
		{{csrf_field()}}
		<div class="form-group">
			<label for="name">Name:</label>
			<input type="text" class="form-control" id="name"  name="name" >
		</div>
		<div class="form-group">
			<label for="URL">URL:</label>
			<input type="text" class="form-control" id="url"  name="url" >
		</div>
		<div class="form-group">
			<label for="tags">Tags</label>
			

			<textarea id="tags" name = "tags" class ="form-control" ></textarea>
		</div>
		<div class = 'class form-group'>
			<button type="submit" class="btn btn-primary">Publish</button>
		</div>
		



	</form>
</div>
@stop