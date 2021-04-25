@extends('layouts.adminlte.master')
@section('title', $title)

@section('css')
<style>
    .dash {
        border-bottom: 1px dashed #000000;
        border-collapse: collapse;
    }
</style>
@endsection

@section('body')
    <div class="form-row">
        <div class="form-group col-md-12">

            <p class="text-bold">Bagian 1 : Rincian Data Pemohon Sertifikasi</p>
            <p>Pada bagian ini, cantumlah data pribadi, data pendidikan formal serta data pekerjaan anda pada saat ini</p>

            <p>
                <ol type="a">
                    <li>
                        <span class="text-bold">Data Pribadi</span>

                        <div class="table-responsive mt-2 mb-2">
                            <table class="table-sm">
                                <tbody>
                                    <tr>
                                        <td width="20%">{{ trans('form.name') }}</td>
                                        <td width="2%">:</td>
                                        <td width="75%" class="dash">{{ $query->name }}</td>
                                    </tr>
                                    <tr>
                                        <td width="20%">{{ trans('form.nik') }}</td>
                                        <td width="2%">:</td>
                                        <td width="75%" class="dash">{{ $query->no_ktp }}</td>
                                    </tr>
                                    <tr>
                                        <td width="20%">{{ __('Tempat') }}/{{ trans('form.birth_date') }}</td>
                                        <td width="2%">:</td>
                                        <td width="75%" class="dash">{{ $query->birth_place }}, {{ \Carbon\Carbon::parse($query->birth_date)->format('d-m-Y') }}</td>
                                    </tr>
                                    <tr>
                                        <td width="20%">{{ trans('form.gender') }}</td>
                                        <td width="2%">:</td>
                                        <td width="75%" class="dash">
                                            @php
                                                // untuk hitung loop buat strip (/)
                                                $countKey = 0;
                                            @endphp

                                            @foreach(config('options.user_assesi_gender') as $gender)

                                                @if($countKey > 0 )
                                                    {{ __('/') }}
                                                @endif

                                                <span style="@if($query->gender != $gender) {{ __("text-decoration: line-through;") }} @endif">{{ $gender }}</span>

                                                @php
                                                    $countKey = $countKey+1
                                                @endphp
                                            @endforeach
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="20%">{{ __('Kebangsaan') }}</td>
                                        <td width="2%">:</td>
                                        <td width="75%" class="dash">{{ __('Indonesia') }}</td>
                                    </tr>
                                    <tr>
                                        <td width="20%">{{ trans('form.address') }}</td>
                                        <td width="2%">:</td>
                                        <td width="75%" class="dash">{{ $query->address }}</td>
                                    </tr>
                                    <tr>
                                        <td width="20%">{{ __('No. Telpon/Email') }}</td>
                                        <td width="2%">:</td>
                                        <td width="75%">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <div class="col-md-3">Rumah :</div>
                                                        <div class="col dash">{{ $query->phone_number ?? '' }}</div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <div class="col-md-2">HP :</div>
                                                        <div class="col dash">{{ $query->phone_number ?? '' }}</div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <div class="col-md-3">Kantor :</div>
                                                        <div class="col dash">{{ $query->phone_number ?? '' }}</div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <div class="col-md-2">Email :</div>
                                                        <div class="col dash">{{ $users->email ?? '' }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="20%">{{ trans('form.last_education') }}</td>
                                        <td width="2%">:</td>
                                        <td width="50%" class="dash">{{ $query->pendidikan_terakhir }}</td>
                                    </tr>
{{--                                    <tr>--}}
{{--                                        <td width="20%">{{ trans('form.has_job') }}</td>--}}
{{--                                        <td width="2%">:</td>--}}
{{--                                        <td width="75%" class="dash">{{ config('options.user_assesi_has_job')[$query->has_job] }}</td>--}}
{{--                                    </tr>--}}
{{--                                    <tr>--}}
{{--                                        <td width="20%">{{ trans('form.job_address') }}</td>--}}
{{--                                        <td width="2%">:</td>--}}
{{--                                        <td width="75%" class="dash">{{ $query->job_address ?? '' }}</td>--}}
{{--                                    </tr>--}}
{{--                                    <tr>--}}
{{--                                        <td width="20%">{{ trans('form.company_name') }}</td>--}}
{{--                                        <td width="2%">:</td>--}}
{{--                                        <td width="75%" class="dash">{{ $query->company_name ?? '' }}</td>--}}
{{--                                    </tr>--}}
{{--                                    <tr>--}}
{{--                                        <td width="20%">{{ trans('form.company_phone') }}</td>--}}
{{--                                        <td width="2%">:</td>--}}
{{--                                        <td width="75%" class="dash">{{ $query->company_phone ?? '' }}</td>--}}
{{--                                    </tr>--}}
{{--                                    <tr>--}}
{{--                                        <td width="20%">{{ trans('form.company_email') }}</td>--}}
{{--                                        <td width="2%">:</td>--}}
{{--                                        <td width="75%" class="dash">{{ $query->company_email ?? '' }}</td>--}}
{{--                                    </tr>--}}
{{--                                    <tr>--}}
{{--                                        <td width="20%">{{ trans('form.is_verified') }}</td>--}}
{{--                                        <td width="2%">:</td>--}}
{{--                                        <td width="75%" class="dash">{{ $query->is_verified ? 'Ya' : 'Tidak' }}</td>--}}
{{--                                    </tr>--}}
{{--                                    <tr>--}}
{{--                                        <td width="20%">{{ trans('form.verification_note') }}</td>--}}
{{--                                        <td width="2%">:</td>--}}
{{--                                        <td width="75%" class="dash">{{ $query->verification_note ?? '' }}</td>--}}
{{--                                    </tr>--}}
                                </tbody>
                            </table>
                        </div>
                    </li>
                    <li>
                        <span class="text-bold">Data Pekerjaan Sekarang</span>

                        <div class="table-responsive mt-2 mb-2">
                            <table class="table-sm">
                                <tbody>
                                    <tr>
                                        <td width="20%">{{ __('Nama Institusi/Perusahaan') }}</td>
                                        <td width="2%">:</td>
                                        <td width="75%" class="dash">{{ $query->company_name ?? '' }}</td>
                                    </tr>
                                    <tr>
                                        <td width="20%">{{ __('Jabatan') }}</td>
                                        <td width="2%">:</td>
                                        <td width="75%" class="dash">{{ $query->job_title ?? '' }}</td>
                                    </tr>
                                    <tr>
                                        <td width="20%">{{ __('Alamat Kantor') }}</td>
                                        <td width="2%">:</td>
                                        <td width="75%" class="dash">{{ $query->job_address ?? '' }}</td>
                                    </tr>
                                    <tr>
                                        <td width="20%">{{ __('No Telp/Fax/Email') }}</td>
                                        <td width="2%">:</td>
                                        <td width="75%">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <div class="col-2">Telp :</div>
                                                        <div class="col dash">{{ $query->company_phone ?? '' }}</div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <div class="col-2">Fax :</div>
                                                        <div class="col dash">{{ $query->company_phone ?? '' }}</div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div class="col-1">Email :</div>
                                                        <div class="col dash">{{ $query->company_email ?? '' }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </li>
                </ol>
            </p>


            <h3>Asesi Custom Data</h3>

            <div class="table-responsive mt-2 mb-2">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th width="40%">Title</th>
                        <th width="25%">Data</th>
                        <th width="10%">Verified</th>
                        <th width="30%">Vertification Note</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($query->asesicustomdata as $asesicustomdata)
                        <tr id="asesicustomdata-{{ $asesicustomdata->id }}">
                            <th scope="row">{{ $asesicustomdata->title }}</th>
                            <td>
                                @if(in_array($asesicustomdata->input_type, ['upload_image', 'upload_pdf']))
                                    @if(!empty($asesicustomdata->value))
                                        {{$asesicustomdata->value}}
                                    @else
                                        File Belum di Unggah
                                    @endif
                                @else
                                    {{ $asesicustomdata->value }}
                                @endif
                            </td>
                            <td>{{ $asesicustomdata->is_verified ? 'YES' : 'NO' }}</td>
                            <td>{{ $asesicustomdata->verification_note }}</td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('js')
{{--    <script>window.print();</script>--}}
@endsection
