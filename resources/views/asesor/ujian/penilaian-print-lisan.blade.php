@extends('layouts.adminlte.master')
@section('title')
    {{ __('FR.IA.07') }} - {{ $title }}
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('print.css') }}" />
@endsection

@section('body')
    <div class="container">
        <div class="form-row">
            <h3>FR.IA.07. PERTANYAAN LISAN</h3>

            <div class="mt-2 mb-2" style="width: 100%">
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
                        <td>{{ (isset($query->ujianjadwal) and !empty($query->ujianjadwal)) ? \Carbon\Carbon::parse($query->ujianjadwal->tanggal)->format('d-m-Y') : '' }}</td>
                    </tr>
                    </tbody>
                </table>
                <p>*Coret yang tidak perlu</p>
            </div>

            <div class="table-responsive mt-2 mb-2">
                <table border="1px" class="table table-bordered">
                    <tbody>
                        <tr>
                            <td class="text-bold">PANDUAN BAGI ASESOR</td>
                        </tr>
                        <tr>
                            <td>
                                <p class="text-bold">Instruksi:</p>
                                <ul>
                                    <li>Pertanyaan lisan merupakan jenis bukti tambahan untuk mendukung bukti-bukti yang sudah ada.</li>
                                    <li>Buatlah pertanyaan lisan yang dapat mencakupi penguatan informasi berdasarkan KUK, batasan variabel, pengetahuan dan ketrampilan esensial, sikap dan aspek kritis.</li>
                                    <li>Perkiraan jawaban dapat dibuat pada lembar lain.</li>
                                    <li>Tanggapan/penilaian dapat diisi dengan centang (v) pada kolom K (kompeten) atau BK (belum kompeten). Dibutuhkan jastifikasi profesional asesor untuk memutuskan hal ini.</li>
                                </ul>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            @foreach($uk_soals as $key => $unitkompentensi)
                @if(isset($unitkompentensi['lisan']) and !empty($unitkompentensi['lisan']))
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

                    <div class="table-responsive mt-2 mb-2">
                        <table border="1px" class="table table-bordered">
                            <tbody>
                            <tr>
                                <td>
                                    <p class="text-bold">Instruksi:</p>
                                </td>
                                <td>
                                    <ol>
                                        <li>Ajukan pertanyaan kepada Asesi dari daftar terlampir untuk mengonfirmasi pengetahuan, sebagaimana diperlukan.</li>
                                        <li>Tulis jawaban Asesi secara singkat di tempat yang disediakan untuk setiap pertanyaan.</li>
                                        <li>Tempatkan centang di kotak untuk mencerminkan prestasi Asesi (Kompeten ‘K’ atau Belum Kompeten ‘BK’).</li>
                                    </ol>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th rowspan="2" class="text-center text-bold"  style="vertical-align: middle;">Pertanyaan</th>
                                    <th colspan="2" class="text-center text-bold"  style="vertical-align: middle;">Rekomendasi</th>
                                </tr>
                                <tr>
                                    <th class="text-center text-bold"  style="vertical-align: middle;">K</th>
                                    <th class="text-center text-bold"  style="vertical-align: middle;">BK</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($unitkompentensi['lisan'] as $key_soal => $soal)
                                <tr>
                                    <td>
                                        <p><span class="text-bold">{{ $key_soal+1 }}. Pertanyaan: </span>  {!! $soal['question'] !!}</p>

                                        <p><span class="text-bold">Kunci Jawaban: </span> {{ $soal['answer_essay'] }} </p>

                                        <p><span class="text-bold">Jawaban: </span>  {{ $soal['user_answer'] }}</p>
                                    </td>
                                    <td class="text-center text-bold"  style="vertical-align: middle;">
                                        <input type="checkbox" @if($soal['max_score'] === 1) {{__('checked')}} @endif onclick="return false;" />
                                    </td>
                                    <td class="text-center text-bold"  style="vertical-align: middle;">
                                        <input type="checkbox" @if($soal['max_score'] !== 1) {{__('checked')}} @endif onclick="return false;" />
                                    </td>
                                </tr>
                            @endforeach
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

            <p class="text-bold">Penyusun dan Validator</p>
            <div class="table-responsive mt-2 mb-2">
                <table border="1px" class="table table-bordered">
                    <thead>
                        <tr>
                            <th width="45%">Nama</th>
                            <th width="10%">Jabatan</th>
                            <th width="45%">Tanda Tangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                            <td>Penyusun</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>Validator</td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>window.print();</script>
@endsection
