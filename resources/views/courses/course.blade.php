
<div class="blog-course">
	<h2 class="blog-course-title"><a href = "/courses/{{$course -> id}}">{{$course->url}}</a></h2>
	
	<p class="blog-course-meta">{{$course->created_at->toFormattedDateString()}}, by {{$course->user->first_name}}{{' '}}{{$course->user->last_name}} </p>

	<p>{{$course->url}}</p>
	<hr>
	<div class ="comment">
		<ul class="list-group">
			@foreach ($course->comments as $comment)
			<li class="list-group-item">
				<strong>
					{{$comment->user->first_name}}
					{{ $comment->created_at->diffForHumans() }}:&nbsp;
					
				</strong>
				{{$comment->body}}
			</li>
			@endforeach
		</ul>
	</div>

	<hr>

	<div class="card">
		<div class = "card-block">
			<form method="POST" action="/courses/{{$course->id}}/comments">

				{{csrf_field()}}
				<div class = "form-group">
					<textarea class = "form-control" name="body" placeholder="Type a comment.."  required>

					</textarea>
				</div>
				<div class = 'class form-group'>
					<button type="submit" class="btn btn-primary">Add Comment</button>
				</div>
			</form>
		</div>
		@include('layouts.errors')
	</div>
</div>