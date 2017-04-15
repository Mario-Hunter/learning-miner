<div class="blog-course col-md-4">
	<h2 class="blog-course-title"><a href = "/courses/{{$course ->id}}">{{$course->name}}</a></h2>
	
	<p class="blog-course-meta">{{$course->created_at->toFormattedDateString()}}, by <a href="/users/{{$course ->user->id}}" >{{$course->user->first_name}}{{' '}}{{$course->user->last_name}}</a></p>

	<p><a href = {{$course->url}} > {{$course->url}}</a> </p>
	<p class="blog-course-meta" >
	@foreach($course->tags()->get() as $tag)

	<a href="/courses/tags/{{$tag->name}}"> {{$tag->name}}</a>
	@endforeach
	</p>


	<div class="form-control"> 
		<div class="container card-block">
			This course is rated as: &nbsp; {{ $course->rank }}
		</div>
		<hr>
		@if(!Auth::guest())

		<form class="form-group" method="POST" action="/courses/{{$course->id}}/rank">

			{{csrf_field()}}

			<select name="rank" class="selectpicker form-control" >

				<option value="" disabled selected>How much would you rate it?</option>
				<option value="1"> 1 </option>
				<option value="2"> 2 </option>
				<option value="3"> 3 </option>
				<option value="4"> 4 </option>
				<option value="5"> 5 </option>
				
			</select>
			<br>
			<input type="submit" name="submit" value="Submit" class="btn btn-primary">
			
		</form>

		<!-- 
		<form method="POST" action="/courses/{{$course->id}}/rankL">

			{{csrf_field()}}
			
			<button type="submit" name="rank">Like</button>
		</form>


		<form method="POST" action="/courses/{{$course->id}}/rankD">

			{{csrf_field()}}
			
			<button type="submit" name="rank">DisLike</button>
		</form>
	 	-->
		@endif	
	</div>		
</div>

<div class="col-md-8">

	@include('layouts.commentsSection')

</div>

<hr>
<br>

