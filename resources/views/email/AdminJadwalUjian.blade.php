@component('mail::message')

# Tentukan Jadwal Ujian Asesi dan Asesor

Pembayaran dari asesi telah dikonfirmasi, silahkan tentukan jadwal ujian untuk asesi dan tentukan asesor untuk asesi tersebut.

## Data Asesi

@component('mail::table')
| | | |
|-|-|-|
| Email | : | {{ $asesi->email ?? '' }} |
| Nama | : | {{ !empty($asesi->asesi) ? $asesi->asesi->name : '' }} |
@endcomponent

@component('mail::button', ['url' => '', 'color' => 'success'])
Pengaturan Jadwal Ujian
@endcomponent

@component('mail::button', ['url' => ''])
Jadwal Ujian Asesi
@endcomponent

Terima Kasih,<br>
{{ config('app.name') }}
@endcomponent
