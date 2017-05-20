
<body class="profile">
  <div class = "usernametext" >{{$user->first_name}}{{' '}}{{$user->last_name}}</div>
  <object data="/images/purpleBack" type="image/jpg" class="userphoto">
    <img width="210" height="279" src="{{$user->avatar}}"/>
  </object>
    <!--<form enctype="multipart/form-data" action="/userInfo/{{$user->id}}" method="POST">
			<input type="file" name="avatar">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="file" class="pull-right btn btn-sm btn-primary">
	</form>-->

<img class="eminerPhoto" src="/images/BoldLogo3.png"> 

	 <table class= "userdata ">
                    <tbody>
                      <tr>
                      	<td><STRONG>UserEmail:&nbsp;</STRONG><br/></td>
                        <td>{{$user->email}} <br/></td>
						 
                      </tr>
					 <br/>
                      <tr>
                      	<td><STRONG>DOB:&nbsp;</STRONG> <br/></td>
                        <td>{{ Carbon\Carbon::parse($user->dob)->format('d-F-Y') }} <br/></td>
					 
                      </tr>
                        <br/>
          			        <tr>
                      	<td><STRONG>Gender  :&nbsp;</STRONG> <br/></td>
                        <td>{{$user->gender}} <br/></td>
					 
                      </tr>
                     <br/>
                      <tr>
                      	<td><STRONG>Score    :&nbsp;</STRONG> <br/></td>
                        <td>{{$user->user_score}} <br/></td>
                      </tr>
         
                    </tbody>
       </table>
	   <button class="changePicturebutton">CHANGE PHOTO&nbsp;&nbsp;</button>
    <form enctype="multipart/form-data" action="/userInfo/{{$user->id}}" method="POST">
			<input type="file" class="uploadphoto" name="avatar">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
	</form>
 </body>

	@foreach($user->courses as $course)

		<!--<li class="list-group-item">
		<strong>

			<h2 class="blog-course-title"><a href = "/courses/{{$course ->id}}">{{$course->name}}</a></h2>
			
	
			<p class="blog-course-meta">{{$course->created_at->toFormattedDateString()}}</p>

			
			<p class="blog-course-meta" >
			@foreach($course->tags()->get() as $tag)

			<a href="/courses/tags/{{$tag->name}}"> {{$tag->name}}</a>
			</p>
			
			@endforeach
			</strong>
			
		</li>-->
		
		@endforeach