@component('mail::message')
# Welcome, {{$user-> first_name}}, to E-Miner

Here You will find all the educational sources you need to push your limits to be someone amazing.

@component('mail::button', ['url' => 'http://127.0.0.1:8000/courses' ])
E-miner
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
