@extends('layouts.adminlte.master')
@section('title')
    {{ __('FR.AK.01') }} - {{ $title }}
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('print.css') }}" />
@endsection

@section('body')
    <div class="container">
        <div class="form-row">
            <h3>FR.AK.01. PERSETUJUAN ASESMEN DAN KERAHASIAAN</h3>

            <div class="mt-2 mb-2">
                <table border="1px" class="table table-bordered">
                    <tbody>
                    <tr>
                        <td colspan="5" style="vertical-align: middle;">
                            Persetujuan Asesmen ini untuk menjamin bahwa Asesi telah diberi arahan secara rinci tentang perencanaan dan proses asesmen
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="3" width="15%" style="vertical-align: middle;">
                            Skema Sertifikasi<br />(KKNI/Okupasi/Klaster)
                        </td>
                    </tr>
                    <tr>
                        <td width="15%">Nomor</td>
                        <td width="1%">:</td>
                        <td colspan="2">{{ (isset($query->sertifikasi) and !empty($query->sertifikasi)) ? $query->sertifikasi->nomor_skema : '' }}</td>
                    </tr>
                    <tr>
                        <td width="15%">Judul</td>
                        <td width="1%">:</td>
                        <td colspan="2" class="text-bold">{{ (isset($query->sertifikasi) and !empty($query->sertifikasi)) ? $query->sertifikasi->title : '' }}</td>
                    </tr>
                    <tr>
                        <td colspan="2" style="vertical-align: middle;">
                            TUK
                        </td>
                        <td width="1%">:</td>
                        <td colspan="2">
                            @php
                                // untuk hitung loop buat strip (/)
                                $countKey = 0;
                                $tuk = $query->order->tuk ?? '';
                            @endphp
                            @foreach(config('options.tuk_type') as $keyTukType => $tukType)

                                @if($countKey > 0 )
                                    {{ __('/') }}
                                @endif
                                @if($keyTukType == $tuk->type)
                                    {{ $tukType }}
                                @else
                                    <span style="text-decoration: line-through;">{{ $tukType }}</span>
                                @endif

                                @php
                                    $countKey = $countKey+1
                                @endphp
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="vertical-align: middle;">
                            Nama Asesor
                        </td>
                        <td width="1%">:</td>
                        <td colspan="2">{{ (isset($query->userasesor->asesor) and !empty($query->userasesor->asesor)) ? $query->userasesor->asesor->name : '' }}</td>
                    </tr>
                    <tr>
                        <td colspan="2" style="vertical-align: middle;">
                            Nama Asesi
                        </td>
                        <td width="1%">:</td>
                        <td colspan="2">{{ (isset($query->userasesi->asesi) and !empty($query->userasesi->asesi)) ? $query->userasesi->asesi->name : '' }}</td>
                    </tr>
                    <tr>
                        <td rowspan="2" colspan="2" style="vertical-align: middle;">
                            Bukti yang akan dikumpulkan :
                        </td>
                        <td width="1%">:</td>
                        <td width="25%">
                            <input type="checkbox" onclick="return false;"> TL : Verifikasi Portofolio
                        </td>
                        <td>
                            <input type="checkbox" onclick="return false;"> L : Observasi Langsung
                        </td>
                    </tr>
                    <tr>
                        <td width="1%">:</td>
                        <td colspan="2">
                            <p><input type="checkbox" onclick="return false;"> T: Hasil Tes Tulis</p>
                            <p><input type="checkbox" onclick="return false;"> T: Hasil Tes Lisan</p>
                            <p><input type="checkbox" onclick="return false;"> T: Hasil Wawancara</p>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="3" colspan="2" style="vertical-align: middle;">
                            Pelaksanaan asesmen disepakati pada
                        </td>
                        <td width="1%">:</td>
                        <td width="25%">
                            Hari/Tanggal
                        </td>
                        <td>
                            @if(isset($query->ujianjadwal) and !empty($query->ujianjadwal))
                                {{ \Carbon\Carbon::parse($query->ujianjadwal->tanggal)->format('d/m/Y') }}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td width="1%">:</td>
                        <td width="25%">Waktu</td>
                        <td>
                            @if(isset($query->ujianjadwal) and !empty($query->ujianjadwal))
                                {{ $query->ujianjadwal->jam_mulai }} - {{ $query->ujianjadwal->jam_berakhir }}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td width="1%">:</td>
                        <td width="25%">TUK</td>
                        <td>{{ $tuk->title ?? '' }}</td>
                    </tr>
                    <tr>
                        <td colspan="5">
                            <p class="text-bold">Asesi:</p>
                            <p>Bahwa Saya Sudah Mendapatkan Penjelasan Hak dan Prosedur Banding Oleh Asesor.</p>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5">
                            <p class="text-bold">Asesor:</p>
                            <p>Menyatakan tidak akan membuka hasil pekerjaan yang saya peroleh karena penugasan saya
                                sebagai Asesor dalam pekerjaan Asesmen kepada siapapun atau organisasi apapun selain
                                kepada pihak yang berwenang sehubungan dengan kewajiban saya sebagai Asesor yang ditugaskan oleh LSP.</p>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5">
                            <p class="text-bold">Asesi:</p>
                            <p>Saya setuju mengikuti asesmen dengan pemahaman bahwa informasi yang dikumpulkan
                                hanya digunakan untuk pengembangan profesional dan hanya dapat diakses oleh orang tertentu saja.</p>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5">
                            <div class="row">
                                <div class="col-md-12 m-4">
                                    <div class="row">
                                        <div class="col-md-6">
                                            Tanda Tangan Asesor:

                                            @if(isset($query->userasesor) and !empty($query->userasesor) and !empty($query->userasesor->media_url_sign_user))
                                                <img height="70px" width="70px" src="{{ $query->userasesor->media_url_sign_user }}">
                                            @else
                                                <br /><br />
                                            @endif
                                        </div>
                                        <div class="col-md-6">
                                            Tanggal: {{ \Carbon\Carbon::now()->format('d/m/Y') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 m-4">
                                    <div class="row">
                                        <div class="col-md-6">
                                            Tanda Tangan Asesi:

                                            @if(isset($query->userasesi) and !empty($query->userasesi) and isset($query->userasesi->asesi) and !empty($query->userasesi->asesi) and !empty($query->userasesi->asesi->media_url_sign_user))
                                                <img height="70px" width="70px" src="{{ $query->userasesi->asesi->media_url_sign_user }}">
                                            @else
                                                <br /><br />
                                            @endif
                                        </div>
                                        <div class="col-md-6">
                                            Tanggal: {{ \Carbon\Carbon::now()->format('d/m/Y') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <p>*Coret yang tidak perlu</p>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>window.print();</script>
@endsection
