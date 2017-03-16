@extends('layouts.app')

@section('content')
<div class="col-sm-8 blog-main">


	@include('courses.course')





<nav>
	<ul class="pager">
		<li><a href="#">Previous</a></li>
		<li><a href="#">Next</a></li>
	</ul>
</nav>

</div><!-- /.blog-main -->
@stop