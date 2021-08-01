@extends('layouts.adminlte.master')
@section('title')
    {{ __('FR.IA.08') }} - {{ $title }}
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('print.css') }}" />
@endsection

@section('body')
    <div class="container">
        <div class="form-row">
            <h3>FR.IA.08. CEKLIS VERIFIKASI PORTOFOLIO</h3>

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

            <div class="table-responsive mt-2 mb-2">
                <table border="1px" class="table table-bordered">
                    <tbody>
                        <tr>
                            <td class="bg-orange text-bold">
                                PANDUAN BAGI ASESOR
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Isilah tabel ini sesuai dengan informasi sesuai pertanyaan/pernyataan dalam tabel dibawah ini. <br />
                                Beri tanda centang (√) pada hasil penilaian portfolio berdasarkan aturan bukti.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="table-responsive mt-2 mb-2">
                <table border="1px" class="table table-bordered">
                    <thead>
                        <tr>
                            <th rowspan="3" width="40%" class="text-center" style="vertical-align: middle;">Dokumen Portofolio:</th>
                            <th colspan="8" width="60%" class="text-center" style="vertical-align: middle;">Aturan Bukti</th>
                        </tr>
                        <tr>
                            <th colspan="2" width="15%" class="text-center" style="vertical-align: middle;">Valid</th>
                            <th colspan="2" width="15%" class="text-center" style="vertical-align: middle;">Asli</th>
                            <th colspan="2" width="15%" class="text-center" style="vertical-align: middle;">Terkini</th>
                            <th colspan="2" width="15%" class="text-center" style="vertical-align: middle;">Memadai</th>
                        </tr>
                        <tr>
                            <th width="7.5%" class="text-center" style="vertical-align: middle;">Ya</th>
                            <th width="7.5%" class="text-center" style="vertical-align: middle;">Tidak</th>
                            <th width="7.5%" class="text-center" style="vertical-align: middle;">Ya</th>
                            <th width="7.5%" class="text-center" style="vertical-align: middle;">Tidak</th>
                            <th width="7.5%" class="text-center" style="vertical-align: middle;">Ya</th>
                            <th width="7.5%" class="text-center" style="vertical-align: middle;">Tidak</th>
                            <th width="7.5%" class="text-center" style="vertical-align: middle;">Ya</th>
                            <th width="7.5%" class="text-center" style="vertical-align: middle;">Tidak</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>(yang memenuhi kriteria VATM yang diinput ke dalam dokumen portofolio)</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>(yang memenuhi kriteria VATM yang diinput ke dalam dokumen portofolio)</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>(yang memenuhi kriteria VATM yang diinput ke dalam dokumen portofolio)</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>


            @foreach($uk_soals as $key => $unitkompentensi)
                @if(isset($unitkompentensi['essay']) and !empty($unitkompentensi['essay']))
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

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td>
                                        Sebagai tindak lanjut dari hasil verifikasi bukti, substansi materi di bawah ini (no elemen yg di cek list) harus diklarifikasi selama wawancara:
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th width="10%" class="text-center" style="vertical-align: middle;">Cek List</th>
                                    <th width="10%" class="text-center" style="vertical-align: middle;">No. Element</th>
                                    <th width="80%" class="text-center" style="vertical-align: middle;">Materi/substansi wawancara (KUK)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td></td>
                                    <td rowspan="3" class="text-center">1.</td>
                                    <td>
                                        Berdasarkan Bukti No : …………………., menetapkan metode dan perangkat analisis jabatan dalam bentuk dokumen tertulis <br />
                                        (TS, TMS, CMS, JRES,TRS).
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>
                                        Berdasarkan Bukti No : …………………., mengidentifikasi Informasi pekerjaan dari setiap jabatan dari berbagai nara sumber di dalam organisasi.<br />
                                        (TS, TMS, CMS, JRES,TRS).
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>
                                        Berdasarkan Bukti No : …………………., menganalisa data dan informasi jabatan berdasarkan metode dan perangkat analisis jabatan yang ditetapkan<br />
                                        (TS, TMS, CMS, JRES,TRS).
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

{{--                    <div class="table-responsive">--}}
{{--                        <table class="table table-bordered">--}}
{{--                            <thead>--}}
{{--                            <tr>--}}
{{--                                <th rowspan="2" width="5%" class="text-center" style="vertical-align: middle;">No.</th>--}}
{{--                                <th rowspan="2" class="text-center" style="vertical-align: middle;">Jawaban</th>--}}
{{--                                <th colspan="2" width="10%" class="text-center" style="vertical-align: middle;">Rekomendasi</th>--}}
{{--                            </tr>--}}
{{--                            <tr class="text-center" style="vertical-align: middle;">--}}
{{--                                <th width="5%">K</th>--}}
{{--                                <th width="5%">BK</th>--}}
{{--                            </tr>--}}
{{--                            </thead>--}}
{{--                            <tbody>--}}
{{--                            @foreach($unitkompentensi['essay'] as $key_soal => $soal)--}}
{{--                                <tr>--}}
{{--                                    <td class="text-center" style="vertical-align: middle;">{{ $key_soal+1 }}</td>--}}
{{--                                    <td>{{ $soal['user_answer'] }}</td>--}}
{{--                                    <td class="text-center" style="vertical-align: middle;">--}}
{{--                                        <input type="checkbox" @if($soal['final_score'] == $soal['max_score']) {{__('checked')}} @endif onclick="return false;" />--}}
{{--                                    </td>--}}
{{--                                    <td class="text-center" style="vertical-align: middle;">--}}
{{--                                        <input type="checkbox" @if($soal['final_score'] != $soal['max_score']) {{__('checked')}} @endif onclick="return false;" />--}}
{{--                                    </td>--}}
{{--                                </tr>--}}
{{--                            @endforeach--}}
{{--                            </tbody>--}}
{{--                        </table>--}}
{{--                    </div>--}}
                @endif
            @endforeach

            <div class="table-responsive">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td colspan="2">
                                <span class="mb-6">Bukti tambahan diperlukan pada unit / elemen kompetensi sebagai berikut:</span>
                            </td>
                        </tr>
                        <tr>
                            <td rowspan="2" class="bg-orange">Rekomendasi Asesor:</td>
                            <td>Asesi telah memenuhi pencapaian seluruh kriteria unjuk kerja, direkomendasikan KOMPETEN</td>
                        </tr>
                        <tr>
                            <td>
                                Asesi belum memenuhi pencapaian seluruh kriteria unjuk kerja, direkomendasikan uji demonstrasi pada: <br />
                                Unit….. <br />
                                Elemen: ….. <br />
                                KUK: ……. <br />
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="table-responsive mt-2 mb-2">
                <table border="1px" class="table table-bordered">
                    <tbody>
                    <tr>
                        <td width="33%">Nama</td>
                        <td width="33%">
                            <p class="text-bold">Asesi:</p>
                            {{ (isset($query->userasesi->asesi) and !empty($query->userasesi->asesi)) ? $query->userasesi->asesi->name : '' }}
                        </td>
                        <td width="33%">
                            <p class="text-bold">Asesor:</p>
                            {{ (isset($query->userasesor->asesor) and !empty($query->userasesor->asesor)) ? $query->userasesor->asesor->name : '' }}
                        </td>
                    </tr>
                    <tr>
                        <td width="33%">Tanda Tangan dan<br/><br/>Tanggal</td>
                        <td width="33%">
                            <p>
                                @if(isset($query->userasesi) and !empty($query->userasesi) and isset($query->userasesi->asesi) and !empty($query->userasesi->asesi) and !empty($query->userasesi->asesi->media_url_sign_user))
                                    <img height="70px" width="70px" src="{{ $query->userasesi->asesi->media_url_sign_user }}">
                                @else
                                    <br /><br />
                                @endif
                            </p>
                            <p>{{ now()->format('d-m-Y') }}</p>
                        </td>
                        <td width="33%">
                            <p>
                                @if(isset($query->userasesor) and !empty($query->userasesor) and !empty($query->userasesor->media_url_sign_user))
                                    <img height="70px" width="70px" src="{{ $query->userasesor->media_url_sign_user }}">
                                @else
                                    <br /><br />
                                @endif
                            </p>
                            <p>{{ now()->format('d-m-Y') }}</p>
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
