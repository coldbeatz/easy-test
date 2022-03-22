@component('mail::message')
# Account activation

Dear **{{ $name }}**

Follow the link to activate your account:<br> <{{ $link }}>

@component('mail::button', ['url' => $link])
    Activate
@endcomponent

<small>If you have not registered to {{ config('app.name') }}, ignore this message.</small>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
