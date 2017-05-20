<nav class="navbar1 navbar navbar-toggleable-md navbar-light bg-faded">
  <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
    @if(Request::url() === 'http://localhost:8000/courses')
  <a class="eminerButton" href="/courses" onclick="location.replace('http://localhost:8000/courses'),'_top'" width="300" height = "100">
    <img src="/images/eminer2.jpg" width="200" height="50" alt="">
  </a>
    @else
 <a class="eminerButton" href="/courses" onclick="location.replace('http://localhost:8000/courses'),'_top'" width="300" height = "100">
    <img src="/images/eminer.jpg" width="200" height="50" alt="">
  </a>
    @endif
    
  <div class = "logoGroup">
  	   <img src="/images/icon.png" width="180" height="100"  alt="">
  </div>
  <div class = "logoLamp">
  <img src="/images/lamp.png"  width="200" height="180"  alt="">
      </div>
  @if(Auth::guest())
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="navbutton1">
        <a class="nav-link" href="{{ route('login') }}">Login <span class="sr-only">(current)</span></a>
      </li>
      <li class="navbutton2">
        <a class="nav-link" href="{{ route('register') }}">Register</a>
      </li>
    </ul>
   <form class="form-inline my-2 my-lg-0" action="/search" method="POST">

    {{csrf_field()}}
    
      <input class="form-control mr-sm-2" type="text" name="name" placeholder="Search" required>
    
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    
    </form>
  </div>

  @else
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="navbutton1">
          @if(Request::route()->getName() === 'home') 
        <a class="nav-link active" href="/home/1">Home<span class="sr-only">(current)</span></a>
          @else
        <a class="nav-link " href="/home/1">Home<span class="sr-only">(current)</span></a>
          @endif
      </li>
      <li class="navbutton2">
           @if(Request::route()->getName() === 'interests') 
        <a class="nav-link active" href="/interests/courses/1">My Courses</a>
          @else
         <a class="nav-link" href="/interests/courses/1">My Courses</a>
          @endif
      </li>
	   <li class="navbutton3">
          @if(Request::url() === 'http://localhost:8000/courses/create') 
        <a class="nav-link active" href="/courses/create">Add course</a>
           @else
           <a class="nav-link" href="/courses/create">Add course</a>
            @endif
      </li>
        
      <li class="navbutton4">
           @if(Request::url() === 'http://localhost:8000/userInfo/1') 
        <a class="nav-link active2" href="/userInfo/{{auth()->user()->id}}">My info</a>
          @else
        <a class="nav-link" href="/userInfo/{{auth()->user()->id}}">My info</a>
          @endif
      </li>
	  <li class="navbutton5">
        <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();
              document.getElementById('logout-form').submit();">Log out</a>
			   <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
          </form>
      </li>
    </ul>
   <form class="form-inline my-2 my-lg-0" action="/search" method="POST">

    {{csrf_field()}}
    
      <input class="form-control mr-sm-2" type="text" name="name" placeholder="Search" required>
    
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    
    </form>
  </div>
    @endif
</nav>