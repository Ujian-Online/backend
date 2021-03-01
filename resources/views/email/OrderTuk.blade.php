@component('mail::message')
# Verifikasi Data Pembayaran Oleh Asesi

## Detail Order

@component('mail::table')
| | | |
|-|-|-|
| Email | : | {{ $asesi->email ?? '' }} |
| Nama Asesi | : | {{ !empty($asesi->asesi) ? $asesi->asesi->name : '' }} |
| Sertifikati | : | {{ !empty($order->sertifikasi) ? $order->sertifikasi->title : '' }}
| Training | : | {{ $order->tuk_price_training ? 'Yes' : 'No' }} |
| Sertifikasi Ulang | : | **{{ ucfirst($order->tipe_sertifikasi) }}** |
@endcomponent

## Ringkasan Biaya

@component('mail::table')
| Keterangan | Biaya |
| ---------- | ----- |
| Biaya Sertifikat | Rp. {{ number_format($order->tuk_price, 0,',','.') }} |
| Biaya Training | Rp. {{  !empty($order->tuk_price_training) ? number_format($order->tuk_price_training, 0,',','.') : '-' }} |
| **Total Biaya** | **Rp. {{ number_format(!empty($order->tuk_price_training) ? ($order->tuk_price + $order->tuk_price_training ) : $order->tuk_price, 0,',','.') }}** |
@endcomponent


@component('mail::button', ['url' => route('admin.order.edit', $order->id) ])
    Verifikasi Pembayaran Asesi
@endcomponent

Terima Kasih,<br>
{{ config('app.name') }}
@endcomponent
