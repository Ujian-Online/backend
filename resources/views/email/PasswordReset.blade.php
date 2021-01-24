@component('mail::message')
# Hi {{ $user->email }},

Silahkan klik link dibawah ini untuk melakukan reset password akun anda.

@component('mail::button', ['url' => $url ])
Reset Password
@endcomponent

Terima Kasih,<br>
{{ config('app.name') }}
@endcomponent
