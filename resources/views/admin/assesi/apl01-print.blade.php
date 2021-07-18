@extends('layouts.adminlte.master')
@section('title')
    {{ __('FR.APL.01') }} - {{ $title }}
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('print.css') }}" />
@endsection

@section('body')
    <div class="container">
        <div class="form-row">
            <h2>FR.APL.01. PERMOHONAN SERTIFIKASI KOMPETENSI</h2>

            <div class="form-group col-md-12">

                <h2>Bagian 1 : Rincian Data Pemohon Sertifikasi</h2>
                <p>Pada bagian ini, cantumlah data pribadi, data pendidikan formal serta data pekerjaan anda pada saat ini</p>

                <p>
                <ol type="a">
                    <li>
                        <span class="text-bold">Data Pribadi</span>

                        <div>
                            <div class="mt-2 mb-2">
                                <table class="table-sm">
                                    <tbody>
                                    <tr>
                                        <td width="20%">{{ trans('form.name') }}</td>
                                        <td width="2%">:</td>
                                        <td class="dash">{{ $query->name }}</td>
                                    </tr>
                                    <tr>
                                        <td width="20%">{{ trans('form.nik') }}</td>
                                        <td width="2%">:</td>
                                        <td class="dash">{{ $query->no_ktp }}</td>
                                    </tr>
                                    <tr>
                                        <td width="20%">{{ __('Tempat') }}/{{ trans('form.birth_date') }}</td>
                                        <td width="2%">:</td>
                                        <td class="dash">{{ $query->birth_place }}, {{ \Carbon\Carbon::parse($query->birth_date)->format('d-m-Y') }}</td>
                                    </tr>
                                    <tr>
                                        <td width="20%">{{ trans('form.gender') }}</td>
                                        <td width="2%">:</td>
                                        <td class="dash">
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
                                        <td class="dash">{{ __('Indonesia') }}</td>
                                    </tr>
                                    <tr>
                                        <td width="20%">{{ trans('form.address') }}</td>
                                        <td width="2%">:</td>
                                        <td class="dash">{{ $query->address }}</td>
                                    </tr>
                                    <tr>
                                        <td width="20%">{{ __('No. Telpon/Email') }}</td>
                                        <td width="2%">:</td>
                                        <td>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <div class="col-md-3">Rumah:</div>
                                                        <div class="col dash"></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <div class="col-md-2">HP:</div>
                                                        <div class="col dash">{{ $query->phone_number ?? '' }}</div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <div class="col-md-3">Kantor:</div>
                                                        <div class="col dash"></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <div class="col-md-2">Email:</div>
                                                        <div class="col dash">{{ $users->email ?? '' }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="20%">{{ trans('form.last_education') }}</td>
                                        <td width="2%">:</td>
                                        <td class="dash">{{ $query->pendidikan_terakhir }}</td>
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
                        </div>
                    </li>
                    <li>
                        <span class="text-bold">Data Pekerjaan Sekarang</span>

                        <div class="mt-2 mb-2">
                            <table class="table-sm">
                                <tbody>
                                <tr>
                                    <td width="20%">{{ __('Nama Institusi/ Perusahaan') }}</td>
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
                                                    <div class="col dash"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-2">Email :</div>
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

                <h2>Bagian 2 : Data Sertifikasi</h2>
                <p>Tuliskan Judul dan Nomor Skema Sertifikasi yang anda ajukan berikut Daftar Unit Kompetensi sesuai kemasan pada skema sertifikasi untuk mendapatkan pengakuan sesuai dengan latar belakang pendidikan, pelatihan serta pengalaman kerja yang anda miliki.</p>

                <div class="form-group col-md-12">
                    <div class="mt-2 mb-2">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td rowspan="3" class="text-center text-bold"  style="vertical-align: middle;" width="20%">
                                        Skema Sertifikasi<br/>(KKNI/Okupasi/Klaster)
                                    </td>
                                </tr>
                                <tr>
                                    <td>Judul</td>
                                    <td width="1%">:</td>
                                    <td class="text-bold">{{ (isset($query->singleorder->sertifikasi) and !empty($query->singleorder->sertifikasi->title)) ? $query->singleorder->sertifikasi->title : '' }}</td>
                                </tr>
                                <tr>
                                    <td>Nomor</td>
                                    <td width="1%">:</td>
                                    <td class="text-bold">{{ (isset($query->singleorder->sertifikasi) and !empty($query->singleorder->sertifikasi->title)) ? $query->singleorder->sertifikasi->nomor_skema : '' }}</td>
                                </tr>
                                <tr>
                                    <td colspan="2" rowspan="5">Tujuan Asesmen</td>
                                    <td width="1%" rowspan="5">:</td>
                                    <td class="text-bold">
                                        <input type="checkbox" @if($query->singleorder->tipe_sertifikasi === 'baru') {{__('checked')}} @endif onclick="return false;" /> Sertifikasi
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-bold">
                                        <input type="checkbox" @if($query->singleorder->tipe_sertifikasi === 'perpanjang') {{__('checked')}} @endif onclick="return false;" /> Sertifikasi Ulang
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-bold">
                                        <input type="checkbox" @if($query->singleorder->tipe_sertifikasi === 'pkt') {{__('checked')}} @endif onclick="return false;" /> Pengakuan Kompetensi Terkini (PKT)
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-bold">
                                        <input type="checkbox" @if($query->singleorder->tipe_sertifikasi === 'rpl') {{__('checked')}} @endif onclick="return false;" /> Rekognisi Pembelajaran Lampau
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-bold">
                                        <input type="checkbox" @if($query->singleorder->tipe_sertifikasi === 'lainnya') {{__('checked')}} @endif onclick="return false;" /> Lainnya
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <p class="text-bold">Daftar Unit Kompetensi sesuai kemasan:</p>

                <div class="form-group col-md-12">
                    <div class="mt-2 mb-2">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th width="5%" class="text-center" style="vertical-align: middle;">No.</th>
                                <th width="25%" class="text-center" style="vertical-align: middle;">Kode Unit</th>
                                <th width="50%" class="text-center" style="vertical-align: middle;">Judul Unit</th>
                                <th width="20%" class="text-center" style="vertical-align: middle;">Jenis Standar (Standar Khusus/Standar Internasional/SKKNI)</th>
                            </tr>
                            </thead>
                            <tbody>
                                @if(isset($query->singleorder->sertifikasi->sertifikasiunitkompentensi) and !empty($query->singleorder->sertifikasi->sertifikasiunitkompentensi))
                                    @foreach($query->singleorder->sertifikasi->sertifikasiunitkompentensi as $key_suk => $suk)
                                        <tr>
                                            <th class="text-center">{{ $key_suk+1 }}.</th>
                                            <td>{{ $suk->unitkompetensi && $suk->unitkompetensi->kode_unit_kompetensi ? $suk->unitkompetensi->kode_unit_kompetensi : '' }}</td>
                                            <td>{{ $suk->unitkompetensi && $suk->unitkompetensi->title ? $suk->unitkompetensi->title : '' }}</td>
                                            <td>{{ $suk->unitkompetensi && $suk->unitkompetensi->jenis_standar ? $suk->unitkompetensi->jenis_standar : '' }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>


                <h2>Bagian 3 : Bukti Kelengkapan Pemohon</h2>
                <p class="text-bold">Bukti Persyaratan Dasar Pemohon</p>

                <div class="mt-2 mb-2">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th rowspan="2" width="5%" class="text-center" style="vertical-align: middle;">No.</th>
                                <th rowspan="2" width="40%" class="text-center" style="vertical-align: middle;">Bukti Persyaratan Dasar</th>
                                <th colspan="2" width="25%" class="text-center" style="vertical-align: middle;">Ada</th>
                                <th rowspan="2" width="25%" class="text-center" style="vertical-align: middle;">Tidak Ada</th>
                            </tr>
                            <tr>
                                <th width="15%" class="text-center" style="vertical-align: middle;">Memenuhi Syarat </th>
                                <th width="15%" class="text-center" style="vertical-align: middle;">Tidak Memenuhi Syarat </th>
                            </tr>
                        </thead>
                        <tbody>

                        @foreach($query->asesicustomdata as $key => $asesicustomdata)
                            <tr id="asesicustomdata-{{ $asesicustomdata->id }}">
                                <th scope="row" class="text-center" style="vertical-align: middle;">{{ $key+1 }}.</th>
                                <th scope="row">{{ $asesicustomdata->title }}</th>
                                <td class="text-center" style="vertical-align: middle;">
                                    <input type="checkbox" @if($asesicustomdata->is_verified) {{__('checked')}} @endif onclick="return false;" />
                                </td>
                                <td class="text-center" style="vertical-align: middle;">
                                    <input type="checkbox" @if(!$asesicustomdata->is_verified) {{__('checked')}} @endif onclick="return false;" />
                                </td>
                                <td>{{ $asesicustomdata->verification_note }}</td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>

                <div class="mt-2 mb-2">
                    <table class="table table-bordered table-sm">
                        <tbody>
                            <tr>
                                <td rowspan="4" width="50%">
                                    <b>Rekomendasi (diisi oleh LSP):</b><br/>
                                    Berdasarkan ketentuan persyaratan dasar, maka pemohon:<br/>
                                    @if($query->is_verified)
                                        <b>Diterima/ <span style="text-decoration: line-through;">Tidak Diterima</span></b>
                                    @else
                                        <b><span style="text-decoration: line-through;">Diterima</span>/ Tidak diterima</b>
                                    @endif
                                    *) sebagai peserta  sertifikasi<br/>
                                    * coret yang tidak sesuai
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" width="50%" class="text-bold">Pemohon/ Kandidat :</td>
                            </tr>
                            <tr>
                                <td width="20%">Nama</td>
                                <td width="30%">{{ $query->name }}</td>
                            </tr>
                            <tr>
                                <td width="20%">Tanda Tangan/ Tanggal</td>
                                <td width="30%">
                                    <p>
                                        @if(isset($users->media_url_sign_user) and !empty($users->media_url_sign_user))
                                            <img src="{{ $users->media_url_sign_user }}">
                                        @else
                                            {{ __('-') }}
                                        @endif
                                    </p>
                                    <p>{{ $query->singleorder->created_at->format('d/m/Y') }}</p>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-bold">Catatan:</td>
                                <td colspan="2" class="text-bold">Admin LSP:</td>
                            </tr>
                            <tr>
                                <td rowspan="4" width="50%">
                                    {!! $query->verification_note !!}
                                </td>
                            </tr>
                            <tr>
                                <td width="20%">Nama</td>
                                <td width="30%"></td>
                            </tr>
                            <tr>
                                <td width="20%">No Reg</td>
                                <td width="30%"></td>
                            </tr>
                            <tr>
                                <td width="20%">Tanda Tangan/ Tanggal</td>
                                <td width="30%">
                                    <p>
                                        @if(isset($query->admin) and isset($query->admin->media_url_sign_user) and !empty($query->admin->media_url_sign_user))
                                            <img src="{{ $query->admin->media_url_sign_user }}">
                                        @else
                                            {{ __('-') }}
                                        @endif
                                    </p>
                                    <p>{{ $query->singleorder->updated_at->format('d/m/Y') }}</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>window.print();</script>
@endsection
