@extends('layouts.pageForm')

@section('css')
    <style>
        td {
            border: 1px solid black !important;
        }

        th {
            border: 1px solid black !important;
        }
    </style>
@endsection

@section('form')
    @include('layouts.alert')

    <div class="form-row">
        <div class="form-group col-md-12">

            <button type="button" class="btn btn-success mb-2" onclick="window.open('{{ request()->url() }}?print=true', '', 'fullscreen=yes');">
                <i class="fas fa-print"></i> Cetak Draft FR.APL.02</a>
            </button>

            <div class="mt-2 mb-2">
                <table class="table table-bordered">
                    <tbody>
                    <tr>
                        <td rowspan="3" class="text-center text-bold bg-success"  style="vertical-align: middle;">
                            Skema Sertifikasi<br/>(KKNI/Okupasi/Klaster)
                        </td>
                    </tr>
                    <tr>
                        <td>Judul</td>
                        <td width="1%">:</td>
                        <td class="text-bold bg-success">{{ $query->title ?? '' }}</td>
                    </tr>
                    <tr>
                        <td>Nomor</td>
                        <td width="1%">:</td>
                        <td class="text-bold">{{ $query->nomor_skema ?? '' }}</td>
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
                                            <p>{!! nl2br($ukelement->desc) !!}</p>
                                            <p>{!! nl2br($ukelement->upload_instruction) !!}</p>
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
@endsection
