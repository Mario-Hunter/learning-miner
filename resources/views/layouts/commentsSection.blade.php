<ul class="list-group">
	<div class="pre-scrollable">
		@foreach ($course->comments as $comment)
			<li class="list-group-item">
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