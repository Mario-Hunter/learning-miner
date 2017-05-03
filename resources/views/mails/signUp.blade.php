@component('mail::message')
# Welcome, {{$user-> first_name}}, to E-Miner

Here You will find all the educational sources you need to push your limits to be someone amazing.

@component('mail::button', ['url' => URL::to('register/verify/' .$user-> confirmation_code)  ])
Verify,helo
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
