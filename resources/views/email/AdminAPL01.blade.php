@component('mail::message')

# Update Data Asesi Perlu di Verifikasi

## Data Asesi APL01

@component('mail::table')
| | | |
|-|-|-|
| Nama | : | {{ !empty($asesi->asesi) ? $asesi->asesi->name : '' }} |
| Alamat | : | {{ !empty($asesi->asesi) ? $asesi->asesi->address : '' }} |
| Nomor Telpon | : | {{ !empty($asesi->asesi) ? $asesi->asesi->phone_number : '' }} |
| Jenis Kelamin | : | {{ !empty($asesi->asesi) ? $asesi->asesi->gender : '' }} |
| Tempat Lahir | : | {{ !empty($asesi->asesi) ? $asesi->asesi->birth_place : '' }} |
| Tanggal Lahir | : | {{ !empty($asesi->asesi) ? ($asesi->asesi->birth_date ? \Carbon\Carbon::parse($asesi->asesi->birth_date)->format('d/m/Y') : '') : '' }} |
| Nomor KTP | : | {{ !empty($asesi->asesi) ? $asesi->asesi->no_ktp : '' }} |
| Pendidikan Terakhir | : | {{ !empty($asesi->asesi) ? $asesi->asesi->pendidikan_terakhir : '' }} |
| Bekerja | : | {{ !empty($asesi->asesi) ? ($asesi->asesi->has_job ? 'Bekerja' : 'Tidak Bekerja') : '' }} |
| Jenis Pekerjaan | : | {{ !empty($asesi->asesi) ? $asesi->asesi->job_title : '' }} |
| Alamat Pekerjaan | : | {{ !empty($asesi->asesi) ? $asesi->asesi->job_address : '' }} |
| Nama Perusahaan | : | {{ !empty($asesi->asesi) ? $asesi->asesi->company_name : '' }} |
| Telp. Perusahaan | : | {{ !empty($asesi->asesi) ? $asesi->asesi->company_phone : '' }} |
| Email Perusahaan | : | {{ !empty($asesi->asesi) ? $asesi->asesi->company_email : '' }} |
@endcomponent

@if(!empty($customData))
# APL01 Custom Data

@component('mail::table')
| Detail | Data |
|-|-|
@if(!empty($customData))
@if($customData->input_type == 'upload_image' OR $customData->input_type == 'upload_pdf')
| {{ !empty($customData) ? $customData->title : '' }} | <a href="{{ !empty($customData) ? $customData->value : '#' }}" class="btn btn-sm btn-primary">Link</a> |
@else
| {{ !empty($customData) ? $customData->title : '' }} | {{ !empty($customData) ? $customData->value : '#' }} |
@endif
@endif
@endcomponent
@endif

@component('mail::button', ['url' => route('admin.asesi.apl01.show', $asesi->asesi->id)])
    Verifikasi APL01
@endcomponent


Terima Kasih,<br>
{{ config('app.name') }}
@endcomponent
