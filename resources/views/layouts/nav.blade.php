<nav class="navbar navbar-toggleable-md navbar-inverse bg-inverse fixed-top">

  <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <a class="navbar-brand" href="/courses">E-Miner</a>

@if(Auth::guest())

  <div class="collapse navbar-collapse" id="navbarsExampleDefault">

    <ul class="navbar-nav mr-auto">
         
      <li class="nav-item active navbar-right">
         
        <a class="nav-link" href="{{ route('login') }}">Login</a>
         
      </li>
         
      <li class="nav-item active navbar-right">
         
        <a class="nav-link" href="{{ route('register') }}">Register</a>
         
      </li>
         
    </ul>
       
    <form class="form-inline my-2 my-lg-0" action="/search" method="POST">

    {{csrf_field()}}
    
      <input class="form-control mr-sm-2" type="text" name="name" placeholder="Search">
    
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    
    </form>
      
  </div>

@else

  <div class="collapse navbar-collapse" id="navbarsExampleDefault">

    <ul class="navbar-nav mr-auto">
         
      <li class="nav-item active">
         
        <a class="nav-link" href="/home">Home</a>
         
      </li>
         
        <li class="nav-item">
         
          <a class="nav-link" href="/courses/create">Add Course</a>
         
        </li>

        <li class="nav-item">
         
          <a class="nav-link" href="/courses">My Courses</a>
         

         
        </li>
         
        <li class="nav-item">
         
          <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();
              document.getElementById('logout-form').submit();">Logout</a>

          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
          </form>
         
        </li>
         
    </ul>
       
    <form class="form-inline my-2 my-lg-0" action="/search" method="POST">
    
      {{csrf_field()}}

      <input class="form-control mr-sm-2" type="text" name="name" placeholder="Search">
  
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
  
    </form>
      
  </div>

@endif

</nav>