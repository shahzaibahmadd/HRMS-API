@component('mail::message')
    # Welcome to HRMS, {{ $user->name }}

    Your account has been successfully created.

    You can now log in using your email:

    **{{ $user->email }}**

    @component('mail::button', ['url' => 'https://www.instagram.com/leomessi/?hl=en'])
        Login Now
    @endcomponent

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
