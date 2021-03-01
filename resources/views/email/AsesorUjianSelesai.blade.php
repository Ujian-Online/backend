@component('mail::message')
# Silahkan Beri Penilaian Ujian dari Asesi

Ujian telah selesai dilakukan oleh asesi, silahkan beri penilaian ujian dari asesi.

@component('mail::table')
| | | |
|-|-|-|
| Email | : | {{ $asesi->email ?? '' }} |
| Nama Asesi | : | {{ !empty($asesi->asesi) ? $asesi->asesi->name : '' }} |
| Sertifikasi | : | {{ !empty($sertifikasi) ? $sertifikasi->title : '' }} |
@endcomponent

@component('mail::button', ['url' => route('admin.ujian-asesi.show', $ujianasesiasesor->id)])
    Beri Penilaian
@endcomponent

Terima Kasih,<br>
{{ config('app.name') }}
@endcomponent
