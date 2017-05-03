@component('mail::message')
# Hello, {{$course->user-> first_name}},

You have just successfully shared a new course "{{$course->name}}" with the e-miner Community.
Keep it up!

@component('mail::button', ['url' => URL::to('courses/' .$course->id)  ])
View Course
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
