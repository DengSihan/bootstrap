@component('mail::message')
## {{ config('email.verification') }}

{{ __('email.your_email_verification_is', ['verification' => '**' . $verification . '**']) }}

<br>
{{ config('app.name') }}
@endcomponent
