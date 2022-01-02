@extends('layouts.adminlte.master')
@section('title')
    {{ __('Draft FR.APL.02') }} - {{ $query->title }}
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('print.css') }}" />
    <style>
        /*Reset OL Number in Parent*/
        tbody {
            counter-reset: item;
        }

        /*Dont Reset OL Number in have multiple*/
        ol {
            list-style-type: none;
            margin: 0;
            padding: 0;
        }

        /*Only Reset OL Number in Child*/
        ol > li > ol {
            list-style-type: none;
            counter-reset: item;
            margin: 0;
            padding: 0;
        }

        ol > li {
            display: table;
            counter-increment: item;
            margin-bottom: 0.6em;
        }

        ol > li:before {
            content: counters(item, ".") ". ";
            display: table-cell;
            padding-right: 0.6em;
        }

        li ol > li {
            margin: 0;
        }

        li ol > li:before {
            content: counters(item, ".") " ";
        }
    </style>
@endsection

@section('body')
    <div class="container">
        <div class="form-row">
            <h3>FR.APL.02. ASESMEN MANDIRI</h3>

            <div class="form-group col-md-12">
                <div class="mt-2 mb-2">
                    <table class="table table-bordered">
                        <tbody>
                        <tr>
                            <td rowspan="3" class="text-center text-bold"  style="vertical-align: middle;">
                                Skema Sertifikasi<br/>(KKNI/Okupasi/Klaster)
                            </td>
                        </tr>
                        <tr>
                            <td>Judul</td>
                            <td width="1%">:</td>
                            <td class="text-bold">{{ $query->title ?? '' }}</td>
                        </tr>
                        <tr>
                            <td>Nomor</td>
                            <td width="1%">:</td>
                            <td class="text-bold">{{ $query->nomor_skema ?? '' }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <div class="mt-2 mb-2">
                    <table class="table table-bordered">
                        <tbody>
                        <tr>
                            <td class="bg-orange text-bold">
                                PANDUAN ASESMEN MANDIRI
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="text-bold">Instruksi:</span>
                                <ul>
                                    <li>Baca setiap pertanyaan di kolom sebelah kiri</li>
                                    <li>Beri tanda centang (√) pada kotak jika Anda yakin dapat melakukan tugas yang dijelaskan.</li>
                                    <li>Isi kolom di sebelah kanan dengan mendaftar bukti yang Anda miliki untuk menunjukkan bahwa Anda melakukan tugas-tugas ini.</li>
                                </ul>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            @if(isset($query->sertifikasiunitkompentensi) and !empty($query->sertifikasiunitkompentensi))

                @foreach($query->sertifikasiunitkompentensi as $key => $suk)
                    <div class="form-group col-md-12">
                        <div class="mt-2 mb-2">
                            <table class="table table-bordered">
                                <tbody>
                                <tr class="text-bold">
                                    <td width="5%">
                                        Unit Kompetensi Nomor:<br/>
                                        {{ $key+1 }}
                                    </td>
                                    <td width="95%" colspan="3">
                                        {{ $suk->unitkompetensi->kode_unit_kompetensi }}<br/>
                                        {{ $suk->unitkompetensi->title }}
                                    </td>
                                </tr>
                                @if(isset($suk->unitkompetensi->ukelement) and !empty($suk->unitkompetensi->ukelement))
                                    <tr class="text-bold">
                                        <td width="55%">@if(isset($suk->unitkompetensi->sub_title) and !empty($suk->unitkompetensi->sub_title)) {{ $suk->unitkompetensi->sub_title }} @endif</td>
                                        <td width="5%" class="text-center">K</td>
                                        <td width="5%" class="text-center">BK</td>
                                        <td width="35%" class="text-center">Bukti yang relevan</td>
                                    </tr>

                                    @php
                                        // untuk buat nomor media id
                                        $mediaKeyID = 0;
                                    @endphp

                                    @foreach($suk->unitkompetensi->ukelement as $key => $ukelement)
                                        {{-- Hidden Input ID Element--}}
                                        <input type="hidden" name="ukelement[id][]" value="{{ $ukelement->id }}">

                                        <tr>
                                            <td>
                                                <ol>
                                                    <li>Element: <span class="text-bold">{!! nl2br($ukelement->desc) !!}</span> <br />
                                                        Kriteria Unjuk Kerja:
                                                        <ol>
                                                            @foreach(explode("\n", $ukelement->upload_instruction) as $keyUI => $upload_instruction)
                                                                <li value="{{ $keyUI+1 }}">{{ $upload_instruction }}</li>
                                                            @endforeach
                                                        </ol>
                                                    </li>
                                                </ol>
                                            </td>
                                            <td class="text-center" style="vertical-align: middle;">
                                                <input type="checkbox" onclick="return false;" />
                                            </td>
                                            <td class="text-center" style="vertical-align: middle;">
                                                <input type="checkbox" onclick="return false;" />
                                            </td>
                                            <td></td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endforeach

            @endif
        </div>
    </div>

@endsection

@section('js')
    <script>window.print();</script>
@endsection
