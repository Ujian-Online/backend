@component('mail::message')

Tolong lakukan verifikasi data APL02 milik Asesi

## Data Asesi

@component('mail::table')
| | | |
|-|-|-|
| Email | : | {{ $asesi->email ?? '' }} |
| Nama | : | {{ !empty($asesi->asesi) ? $asesi->asesi->name : '' }} |
| Sertifikasi | : | {{ $sertifikasi->title }} |
@endcomponent

@component('mail::button', ['url' => route('admin.asesi.apl02.view', ['userid' => $asesi->id, 'sertifikasiid' => $query['sertifikasi_id']])])
Verfikasi data APL02 Klik di sini
@endcomponent

Terima Kasih,<br>
{{ config('app.name') }}
@endcomponent
