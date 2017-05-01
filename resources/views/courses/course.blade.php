<div class="blog-course col-md-4">
	<h2 class="blog-course-title"><a href = "/courses/{{$course ->id}}">{{$course->name}}</a></h2>
	
	<p class="blog-course-meta">{{$course->created_at->toFormattedDateString()}}, by <a href="/users/{{$course ->user->id}}" >{{$course->user->first_name}}{{' '}}{{$course->user->last_name}}</a></p>

	<a id="livePrev" href = {{$course->url}} > {{$course->url}}</a><div class="box"><iframe src="https://en.wikipedia.org/" width = "500px" height = "500px"></iframe></div>
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
		<form  class="form-group" method="post" action="/courses/{{$course->id}}/rank ">
			{{csrf_field() }}
			<div class="col-md-8">
				<p>Your review..</p>
				<input type="hidden" id="star1{{$course->id}}_hidden" value="1">
				<img src="/images/star1.png" onmouseover="change(this.id);" id="star1{{$course->id}}"  class="star">
				<input type="hidden" id="star2{{$course->id}}_hidden" value="2">
				<img src="/images/star1.png" onmouseover="change(this.id);" id="star2{{$course->id}}" class="star">
				<input type="hidden" id="star3{{$course->id}}_hidden" value="3">
				<img src="/images/star1.png" onmouseover="change(this.id);" id="star3{{$course->id}}" class="star">
				<input type="hidden" id="star4{{$course->id}}_hidden" value="4">
				<img src="/images/star1.png" onmouseover="change(this.id);" id="star4{{$course->id}}" class="star">
				<input type="hidden" id="star5{{$course->id}}_hidden" value="5">
				<img src="/images/star1.png" onmouseover="change(this.id);" id="star5{{$course->id}}" class="star">
			</div>

			<input type="hidden" name="starrating" id="rating{{$course->id}}" value="0">
			<input type="submit" value="Submit" name="submit_rating">
		</form> 

		<form method="POST" action="/interest/{{$course->id}}">
			{{csrf_field()}}
			<button class="btn btn-primary" type="submit">Like</button>
		</form>
		@endif	
	</div>		
</div>

<div class="col-md-8">

	@include('layouts.commentsSection')

</div>

<hr>
<br>

