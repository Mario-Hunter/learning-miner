<div class="blog-course col-md-4">
	<img src="/uploads/avatars/{{$user->avatar}}" style="width: 150px; height:150px; float:left; border-radius:100%; margin-right: 25px; ">
	<h2 class="blog-course-title">{{$user->first_name}}{{' '}}{{$user->last_name}}</h2>
	<form enctype="multipart/form-data" action="/userInfo/{{$user->id}}" method="POST">
		<label>Update Profile Image</label>
			<input type="file" name="avatar">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<input type="submit" class="pull-right btn btn-sm btn-primary">
	</form>
	

	<table class="table table-user-information">
                    <tbody>
                      <tr>
                      	<td><STRONG>UserEmail:</STRONG></td>
                        <td>{{$user->email}}</td>
                      </tr>
                      <tr>
                      	<td><STRONG>DOB:</STRONG></td>
                        <td>{{ Carbon\Carbon::parse($user->dob)->format('d-F-Y') }}</td>
                      </tr>

                      <tr>
                      	<td><STRONG>Gender:</STRONG></td>
                        <td>{{$user->gender}}</td>
                      </tr>
                      
                      <tr>
                      	<td><STRONG>Score:</STRONG></td>
                        <td>{{$user->user_score}}</td>
                      </tr>
                     
                    </tbody>
                  </table>
	<hr>

	@foreach($user->courses as $course)

		<li class="list-group-item">
		<strong>

			<h2 class="blog-course-title"><a href = "/courses/{{$course ->id}}">{{$course->name}}</a></h2>
			
	
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