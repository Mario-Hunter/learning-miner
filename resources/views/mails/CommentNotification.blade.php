@component('mail::message')
# Hello, {{$comment->course->user-> first_name}},

{{$comment-> user->first_name}} {{$comment->user->last_name}} has just commented on your course "{{$comment->course->name}}".

@component('mail::button', ['url' => URL::to('courses/' .$comment->course->id)  ])
View Course
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
