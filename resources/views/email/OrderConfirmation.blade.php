@component('mail::message')
# Hi {{ $user->email }},

Mohon segera selesaikan pembayaran anda, agar bisa melanjutkan proses pendaftaran skema uji sertifikasi.

## Data Asesi

@component('mail::table')
| | | |
|-|-|-|
| Nama | : | **{{ !empty($user->asesi) ? $user->asesi->name : $user->email }}** |
| Sertifikasi | : | {{ $order->sertifikasi->title }} |
| TUK | : | {{ $order->tuk->title }} |
| Training | : | {{ $order->tuk_price_training ? 'Yes' : 'No' }} |
| Sertifikasi Ulang | : | **{{ ucfirst($order->tipe_sertifikasi) }}** |
| No. Sertifikat | : | {{ $order->sertifikat_number_old ?? '-' }} |
@endcomponent

## Ringkasan Biaya

@component('mail::table')
| Keterangan | Biaya |
| ---------- | ----- |
| Biaya Sertifikat | Rp. {{ number_format($order->tuk_price, 0,',','.') }} |
| Biaya Training | Rp. {{  !empty($order->tuk_price_training) ? number_format($order->tuk_price_training, 0,',','.') : '-' }} |
| **Total Biaya** | **Rp. {{ number_format(!empty($order->tuk_price_training) ? ($order->tuk_price + $order->tuk_price_training ) : $order->tuk_price, 0,',','.') }}** |
@endcomponent

@if(!empty($order->tuk->bank))

## Transfer ke Bank Melalui

@component('mail::table')
| Bank | Nama Rekening | Nomor Rekening |
| ---- | ------------- | -------------- |
@foreach($order->tuk->bank as $bank)
| {{ $bank->bank_name }} | {{ $bank->account_name }} | {{ $bank->account_number }} |
@endforeach
@endcomponent

@endif


**Setelah melakukan transfer, silahkan untuk upload bukti transfer melalui tombol dibawah ini**

@component('mail::button', ['url' => $url ])
    Upload Bukti Transfer
@endcomponent

Terima Kasih,<br/>
{{ config('app.name') }}
@endcomponent
