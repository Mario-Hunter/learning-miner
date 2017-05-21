
<div class="courseTicketprofile" > 
	 <img class="logo" src="/images/boldlogo3.png" width = "140px" heigth = "110px"/>
	 <div style="width: 500px; height:200px;" class="courseName" ><a href="/courses/{{$course ->id}}">{{$course->name}}</a></div>
	 <div class="coursePhoto">
	 <a href={{$course ->url}}>
	 	  <img src={{$course->image_url}} width = "180" height="220">
		  </a>
	 </div>
	 <div class="author course_style" style="width: 420px; height:40px;">{{$course->created_at->toFormattedDateString()}}, by <a style="color: #D9BA4E" href="/users/{{$course ->user->id}}" >{{$course->user->first_name}}{{' '}}{{$course->user->last_name}}</a></div>
	 <div class="subtitle course_style" style="width: 420px; height:40px;"><a id="livePrev" style="color: #D9BA4E" href = {{$course->url}} > {{$course->url}}</a><div class="box"><iframe src="https://en.wikipedia.org/" width = "500px" height = "500px"></iframe></div></div>
	 
	
	 <div class="summary course_style" style="width: 420px; height:85px;">{{$course->description}}</div>
    <!-- @if($course->description != null)-->
	 <!--@endif-->
	 
	 <div class="tags course_style" style="width: 420px; height:40px;">
	 tags: 
		@foreach($course->tags()->get() as $tag)
		<a href="/courses/tags/{{$tag->name}}"> {{$tag->name}}</a>
		@endforeach
	 </div>
	 @if(!Auth::guest())
		<form  class="ratingsbutton" method="post" action="/courses/{{$course->id}}/rank ">
			{{csrf_field() }}
			<div class="ratings">
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
		@if(!App\User::checkIfInterestExist(Auth::user(),$course)) 
			<form method="POST" action="/interest/{{$course->id}}">
				{{csrf_field()}}
				<a class="likeButton" href="/interest/{{$course->id}}">
			   	<img src = "/images/like.png" width = "55" height = "55"/>
				</a>
			</form>
		@else
			<form method="POST" action="/interest/{{$course->id}}">
				{{csrf_field()}}
				<a class="likeButton" href="/interest/{{$course->id}}">
			   	<img src = "/images/liked.png" width = "55" height = "55"/>
				</a>
			</form>
		@endif
		@endif
	<div style="width : 200px"class="rankEqual">Ranked as :&nbsp; {{ $course->rank }} </div>
</div>
<div class="rightShift col-md-7">

	@include('layouts.commentsSection')

</div>
<hr>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
