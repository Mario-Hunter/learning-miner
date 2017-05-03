@component('mail::message')
# Hello, {{$course->user-> first_name}},

{{$ranking_user->first_name}} {{$ranking_user->last_name}} has just gave a rank of {{$rank}} stars out of 5 on your course "{{$course->name}}".

@component('mail::button', ['url' => URL::to('courses/' .$course->id)  ])
View Course
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
