@extends('layouts.master')

@section('content')


@foreach($coursesNames as $courseCollection)
@foreach($courseCollection as $course)
<div class="container row">
 @include('courses.course')
</div>

<br>
<hr>
@endforeach
@endforeach



@foreach($coursesTags as $courseCollection)
@foreach($courseCollection as $course)
<div class="container row">
 @include('courses.course')
</div>

<br>
<hr>
@endforeach

@endforeach
@stop