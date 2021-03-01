@component('mail::message')
# Tugas Baru Untuk Asesi

Silahkan tentukan ujian untuk asesi dan pilih paket untuk ujian asesi.

## Detail Asesi

@component('mail::table')
| | | |
|-|-|-|
| Email | : | {{ $asesi->email ?? '' }} |
| Nama Asesi | : | {{ !empty($asesi->asesi) ? $asesi->asesi->name : '' }} |
| Sertifikasi | : | {{ !empty($sertifikasi) ? $sertifikasi->title : '' }} |
@endcomponent

@component('mail::button', ['url' => route('admin.soal.paket.index'), 'color' => 'success'])
Pengaturan Soal Paket Ujian Baru
@endcomponent

@component('mail::button', ['url' => route('admin.surat-tugas.index', ['status' => 'menunggu'])])
Pilih Paket Ujian Untuk Asesi
@endcomponent

Terima Kasih,<br>
{{ config('app.name') }}
@endcomponent
