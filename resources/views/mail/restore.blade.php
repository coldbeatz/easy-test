@component('mail::message')
# Password restore

Dear **{{ $name }}**

Your link to password recovery:<br> <{{ $link }}>

@component('mail::button', ['url' => $link])
    Restore
@endcomponent

<small>If you don't want to recover your password to {{ config('app.name') }}, ignore this message.</small>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
