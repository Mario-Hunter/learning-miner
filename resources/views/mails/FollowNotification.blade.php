@component('mail::message')
# Hello, {{$userfollowed-> first_name}},

{{$userfollowing->first_name}} {{$userfollowing->last_name}} has just followed you on your e-miner.

@component('mail::button', ['url' => URL::to('users/' .$userfollowing->id)  ])
Visit his profile.
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
