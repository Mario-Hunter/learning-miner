<div class="blog-course col-md-4">
	<h2 class="blog-course-title"><a href = "/courses/{{$course ->id}}">{{$course->name}}</a></h2>
	
	<p class="blog-course-meta">{{$course->created_at->toFormattedDateString()}}, by {{$course->user->first_name}}{{' '}}{{$course->user->last_name}}</p>

	<p><a href = {{$course->url}} > {{$course->url}}</a> </p>
	<p class="blog-course-meta" >
	@foreach($course->tags()->get() as $tag)

	{{$tag->name}}

	@endforeach
	</p>
</div>

<div class="col-md-8">

	@include('layouts.commentsSection')

</div>

<hr>
<br>

