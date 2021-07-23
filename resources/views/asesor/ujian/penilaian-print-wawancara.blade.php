@extends('layouts.adminlte.master')
@section('title')
    {{ __('FR.IA.09') }} - {{ $title }}
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('print.css') }}" />
@endsection

@section('body')
    <div class="container">
        <div class="form-row">
            <h3>FR.IA.09. PERTANYAAN WAWANCARA</h3>

            <div class="table-responsive mt-2 mb-2">
                <table border="1px" class="table table-bordered">
                    <tbody>
                    <tr>
                        <td rowspan="3" width="15%" style="vertical-align: middle;">
                            Skema Sertifikasi<br />(KKNI/Okupasi/Klaster)
                        </td>
                    </tr>
                    <tr>
                        <td width="15%">Nomor</td>
                        <td width="1%">:</td>
                        <td>{{ (isset($query->sertifikasi) and !empty($query->sertifikasi)) ? $query->sertifikasi->nomor_skema : '' }}</td>
                    </tr>
                    <tr>
                        <td width="15%">Judul</td>
                        <td width="1%">:</td>
                        <td class="text-bold">{{ (isset($query->sertifikasi) and !empty($query->sertifikasi)) ? $query->sertifikasi->title : '' }}</td>
                    </tr>
                    <tr>
                        <td colspan="2" style="vertical-align: middle;">
                            TUK
                        </td>
                        <td width="1%">:</td>
                        <td>
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
                        <td>{{ (isset($query->userasesor->asesor) and !empty($query->userasesor->asesor)) ? $query->userasesor->asesor->name : '' }}</td>
                    </tr>
                    <tr>
                        <td colspan="2" style="vertical-align: middle;">
                            Nama Asesi
                        </td>
                        <td width="1%">:</td>
                        <td>{{ (isset($query->userasesi->asesi) and !empty($query->userasesi->asesi)) ? $query->userasesi->asesi->name : '' }}</td>
                    </tr>
                    <tr>
                        <td colspan="2" style="vertical-align: middle;">
                            Tanggal
                        </td>
                        <td width="1%">:</td>
                        <td>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <p>*Coret yang tidak perlu</p>
            </div>

            @foreach($uk_soals as $key => $unitkompentensi)
                @if(isset($unitkompentensi['wawancara']) and !empty($unitkompentensi['wawancara']))
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                            <tr>
                                <td rowspan="2" width="15%" style="vertical-align: middle;">Unit Kompetensi</td>
                                <td width="10%">Kode Unit</td>
                                <td width="1px">:</td>
                                <td>{{ $unitkompentensi['kode_unit_kompetensi'] }}</td>
                            </tr>
                            <tr>
                                <td width="10%">Judul Unit</td>
                                <td width="1px">:</td>
                                <td>{{ $unitkompentensi['title'] }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                    <p>
                        <b><i>Setiap pertanyaan harus terkait dengan Elemen</i></b> <br />
                        Tuliskan bukti-bukti yang terdapat pada Ceklis Verifikasi Portofolio yang memerlukan
                        wawancara
                    </p>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center" width="5%">No.</th>
                                    <th class="text-center">Bukti – Bukti Kompetensi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($unitkompentensi['apl02']) and !empty($unitkompentensi['apl02']) and count($unitkompentensi['apl02']) > 0))
                                    @foreach($unitkompentensi['apl02'] as $apl02key => $apl02)
                                        <tr>
                                            <td>{{ $apl02key+1 }}</td>
                                            <td>{{ $apl02['description'] }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="2" class="text-center">Data Tidak Ada</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th rowspan="2" colspan="2" class="text-center text-bold"  style="vertical-align: middle;">Daftar Pertanyaan Wawancara</th>
                                    <th rowspan="2" class="text-center text-bold"  style="vertical-align: middle;">Kesimpulan Jawaban Asesi</th>
                                    <th colspan="2" class="text-center text-bold"  style="vertical-align: middle;">Rekomendasi</th>
                                </tr>
                                <tr>
                                    <th class="text-center text-bold"  style="vertical-align: middle;">K</th>
                                    <th class="text-center text-bold"  style="vertical-align: middle;">BK</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($unitkompentensi['wawancara'] as $key_soal => $soal)
                                <tr>
                                    <td width="5%" class="text-center text-bold">{{ $key_soal+1 }}.</td>
                                    <td>{!! $soal['question'] !!}</td>
                                    <td>{{ $soal['user_answer'] }}</td>
                                    <td class="text-center text-bold"  style="vertical-align: middle;">
                                        <input type="checkbox" @if($soal['max_score'] === 1) {{__('checked')}} @endif onclick="return false;" />
                                    </td>
                                    <td class="text-center text-bold"  style="vertical-align: middle;">
                                        <input type="checkbox" @if($soal['max_score'] !== 1) {{__('checked')}} @endif onclick="return false;" />
                                    </td>
                                </tr>
                            @endforeach
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="text-center text-bold"  style="vertical-align: middle;">
                                        <input type="checkbox" onclick="return false;" />
                                    </td>
                                    <td class="text-center text-bold"  style="vertical-align: middle;">
                                        <input type="checkbox" onclick="return false;" />
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                @endif
            @endforeach

            <div class="table-responsive mt-2 mb-2">
                <table border="1px" class="table table-bordered">
                    <tbody>
                    <tr>
                        <td>Nama</td>
                        <td>
                            <p>Asesi:</p>
                            <p>{{ (isset($query->userasesi) and isset($query->userasesi->asesi) and !empty($query->userasesi->asesi->name)) ? $query->userasesi->asesi->name : '' }}</p>
                        </td>
                        <td>
                            <p>Asesor:</p>
                            <p>{{ (isset($query->userasesor) and isset($query->userasesor->asesor) and !empty($query->userasesor->asesor->name)) ? $query->userasesor->asesor->name : '' }}</p>
                        </td>
                    </tr>
                    <tr>
                        <td>Tanda Tangan dan<br />Tanggal</td>
                        <td>
                            @if(isset($query->userasesi) and !empty($query->userasesi->media_url_sign_user))
                                <img src="{{ $query->userasesi->media_url_sign_user }}">
                            @endif
                        </td>
                        <td>
                            @if(isset($query->userasesor) and !empty($query->userasesor->media_url_sign_user))
                                <img src="{{ $query->userasesor->media_url_sign_user }}">
                            @endif
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
@endsection

@section('js')
{{--    <script>window.print();</script>--}}
@endsection
