<div class="card">
	<div class = "card-block">
		<form method="POST" action="/courses/{{$course->id}}/comments">

			{{csrf_field()}}

			<div class = "form-group">
				<textarea class = "form-control" name="body" placeholder="Type a comment.."  required></textarea>
			</div>
			<div class = 'class form-group'>
				<button type="submit" class="btn btn-primary">Add Comment</button>
			</div>
		</form>
	</div>
	@include('layouts.errors')
</div>