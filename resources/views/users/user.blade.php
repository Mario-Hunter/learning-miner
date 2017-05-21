<div class="blog-course col-md-4">
	<h2 class="blog-course-title"><a href = "/users/{{$user ->id}}">{{$user->first_name}}{{' '}}{{$user->last_name}}</a></h2>
	
	@if(!Auth::guest() && auth()->user()->id!=$user->id)
	@if(!App\follower::ifFollowingExists($user))
	<form method="POST" action="/follow/{{$user ->id}}">
			{{csrf_field()}}
			<button class="btn btn-primary" type="submit">Follow</button>
		</form>
	@else
	<form method="POST" action="/follow/{{$user ->id}}">
			{{csrf_field()}}
			<button class="btn btn-primary" type="submit">Unfollow</button>
		</form>
	@endif
	@endif

	
	<hr>

	@foreach($user->courses as $course)

		<li class="list-group-item">
		<strong>

			<h2 class ="blog-course-title"><a href = "/courses/{{$course ->id}}">{{$course->name}}</a></h2>
			
	
			<p class="blog-course-meta">{{$course->created_at->toFormattedDateString()}}</p>

			
			<p class="blog-course-meta" >
			@foreach($course->tags()->get() as $tag)

			<a href="/courses/tags/{{$tag->name}}"> {{$tag->name}}</a>
			</p>
			
			@endforeach
			</strong>
			
		</li>
		
		@endforeach

	</p>

<hr>
<br>