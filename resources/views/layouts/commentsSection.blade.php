<ul class=" list-group commentsBackground">
	<div class="pre-scrollable commentsBackground">
		@foreach ($course->comments as $comment)
			<li class="list-group-item commentsSheetColor ">
				<strong>
					{{$comment->user->first_name}}
					{{ $comment->created_at->diffForHumans() }}:&nbsp;
				</strong>
				{{$comment->body}}
			</li>
		@endforeach
	</div>

	@if(!Auth::guest())
	@include('layouts.addComment')
	@endif
</ul>