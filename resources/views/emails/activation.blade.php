<!-- resources/views/emails/activation.blade.php -->
@component('mail::message')
# Account Activation

Click the button below to activate your account and set your password.

@component('mail::button', ['url' => $activationLink])
Activate Account
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
