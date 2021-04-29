@extends('layouts.adminlte.master')
@section('title')
    {{ __('FR.IA.06') }} - {{ $title }}
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('print.css') }}" />
@endsection

@section('body')
    <div class="container">
        <div class="form-row">
            <h3>FR.IA.06. PERTANYAAN TERTULIS ESAI</h3>

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

                    <p>Jawab semua pertanyaan di bawah ini:</p>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                            @foreach($unitkompentensi['essay'] as $key_soal => $soal)
                                <tr>
                                    <td>{{ $key_soal+1 }}. {{ $soal['question'] }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <p style="font-style: italic;"><span class="text-bold">*</span> Pelatih / Asesor harus menggunakan kebijaksanaan (professional justification) saat menentukan apakah jawaban yang diberikan oleh Asesi dapat diterima atau tidak.</p>
                @endif
            @endforeach

            <div>
                <p class="text-bold">Catatan:</p>
                <p>
                <ul>
                    <li>Daftar pertanyaan dapat berisi pertanyaan dari semua dimensi kompetensi. Jika ada pertanyaan yang tidak dijawab, maka dapat dieksplorasi dari menilai melalui pertanyaan verbal.</li>
                    <li>Pertanyaan juga dapat difokuskan pada akurasi dan presisi yang dapat membantu memberikan rekomendasi tindak lanjut untuk menilai. </li>
                    <li>Pertanyaan presisi jika tidak dapat dijawab, penilai disarankan untuk menambahkan lebih banyak latihan / bekerja di bawah pengawasan, sedangkan jika pertanyaan akurasi dilewatkan maka penilai direkomendasikan untuk pelatihan ulang</li>
                </ul>
                </p>
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
