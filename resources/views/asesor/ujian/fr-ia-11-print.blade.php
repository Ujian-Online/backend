@extends('layouts.adminlte.master')
@section('title')
    {{ __('FR.IA.11') }} - {{ $title }}
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('print.css') }}" />
@endsection

@section('body')
    <div class="container">
        <div class="form-row">
            <h3>FR.IA.11. CEKLIS MENINJAU INSTRUMEN ASESSMEN</h3>

            <div class="mt-2 mb-2" style="width: 100%;">
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
                        <td class="bg-orange text-bold">
                            PANDUAN BAGI PENINJAU/ASESOR
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <ul>
                                <li>Isilah tabel ini sesuai dengan informasi sesuai pertanyaan/pernyataan dalam table dibawah ini.</li>
                                <li>Beri tanda centang (√) pada hasil penilaian MUK berdasarkan tinjauan anda dengan jastifikasi professional anda.</li>
                                <li>Berikan komentar dengan jastifikasi profesional anda</li>
                            </ul>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <div class="table-responsive mt-2 mb-2">
                <table border="1px" class="table table-bordered">
                    <thead>
                    <tr>
                        <th width="40%" class="text-center" style="vertical-align: middle;">Kegiatan Asesmen</th>
                        <th width="10%" class="text-center" style="vertical-align: middle;">Ya</th>
                        <th width="10%" class="text-center" style="vertical-align: middle;">Tidak</th>
                        <th width="40%" class="text-center" style="vertical-align: middle;">Komentar</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>Instruksi perangkat asesmen dan kondisi asesmen diidentifikasi dengan jelas</td>
                        <td class="text-center"><input type="checkbox" /></td>
                        <td class="text-center"><input type="checkbox" /></td>
                        <td><textarea rows="3" style="width: 100%;"></textarea></td>
                    </tr>
                    <tr>
                        <td>Informasi tertulis dituliskan secara tepat</td>
                        <td class="text-center"><input type="checkbox" /></td>
                        <td class="text-center"><input type="checkbox" /></td>
                        <td><textarea rows="3" style="width: 100%;"></textarea></td>
                    </tr>
                    <tr>
                        <td>Kegiatan asesmen membahas persyaratan bukti untuk kompetensi atau kompetensi yang diases</td>
                        <td class="text-center"><input type="checkbox" /></td>
                        <td class="text-center"><input type="checkbox" /></td>
                        <td><textarea rows="3" style="width: 100%;"></textarea></td>
                    </tr>
                    <tr>
                        <td>Tingkat kesulitan bahasa, literasi, dan berhitung sesuai dengan tingkat unit kompetensi yang dinilai.</td>
                        <td class="text-center"><input type="checkbox" /></td>
                        <td class="text-center"><input type="checkbox" /></td>
                        <td><textarea rows="3" style="width: 100%;"></textarea></td>
                    </tr>
                    <tr>
                        <td>Tingkat kesulitan kegiatan sesuai dengan kompetensi atau kompetensi yang diases.</td>
                        <td class="text-center"><input type="checkbox" /></td>
                        <td class="text-center"><input type="checkbox" /></td>
                        <td><textarea rows="3" style="width: 100%;"></textarea></td>
                    </tr>
                    <tr>
                        <td>Contoh, benchmark dan / atau ceklis asesmen tersedia untuk digunakan dalam pengambilan keputusan asesmen.</td>
                        <td class="text-center"><input type="checkbox" /></td>
                        <td class="text-center"><input type="checkbox" /></td>
                        <td><textarea rows="3" style="width: 100%;"></textarea></td>
                    </tr>
                    <tr>
                        <td>Diperlukan modifikasi (seperti yang diidentifikasi dalam Komentar)</td>
                        <td class="text-center"><input type="checkbox" /></td>
                        <td class="text-center"><input type="checkbox" /></td>
                        <td><textarea rows="3" style="width: 100%;"></textarea></td>
                    </tr>
                    <tr>
                        <td>Tugas asesmen siap digunakan:</td>
                        <td class="text-center"><input type="checkbox" /></td>
                        <td class="text-center"><input type="checkbox" /></td>
                        <td><textarea rows="3" style="width: 100%;"></textarea></td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <div class="table-responsive mt-2 mb-2">
                <table border="1px" class="table table-bordered">
                    <tbody>
                    <tr>
                        <td width="33%">
                            Nama Peninjau <br /><br />
                            <textarea rows="1" style="width: 100%;"></textarea>
                        </td>
                        <td width="33%">
                            Tanggal dan Tanda Tangan Peninjau <br /><br />
                            <textarea rows="1" style="width: 100%;"></textarea>
                        </td>
                        <td width="33%">
                            Komentar <br /><br />
                            <textarea rows="2" style="width: 100%;"></textarea>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <button id="print" class="bg-success no-print" style="position:fixed; width:60px; height:60px; bottom:40px; right:40px; border-radius:50px; text-align:center; box-shadow: 2px 2px 3px #999;">
            <i class="fa fa-print fa-2x"></i>
        </button>
    </div>
@endsection

@section('js')
    <script>
        $("#print").on('click', function() {
            window.print();
        })
    </script>
@endsection
