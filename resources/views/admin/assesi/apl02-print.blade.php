@extends('layouts.adminlte.master')
@section('title', $title)

@section('body')
    <div class=""></div>
<div class="form-row">

    <div class="form-group col-md-12">

        <div class="table-responsive mt-2 mb-2">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td rowspan="3" class="text-center text-bold text-success" style="vertical-align: middle;">
                            Skema Sertifikasi
                        </td>
                    </tr>
                    <tr>
                        <td>Judul</td>
                        <td>:</td>
                        <td class="text-success">{{ (isset($sertifikasi) and !empty($sertifikasi)) ? $sertifikasi->title : '' }}</td>
                    </tr>
                    <tr>
                        <td>Nomor</td>
                        <td>:</td>
                        <td>{{ (isset($sertifikasi) and !empty($sertifikasi)) ? $sertifikasi->nomor_skema : '' }}</td>
                    </tr>
                    <tr>
                        <td colspan="2">TUK</td>
                        <td>:</td>
                        <td>
                            @if(isset($tuk) and !empty($tuk))
                                @php
                                // untuk hitung loop buat strip (/)
                                $countKey = 0;
                                @endphp
                                @foreach(config('options.tuk_type') as $keyTukType => $tukType)

                                    @if($countKey > 0 )
                                        {{ _('/') }}
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
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">Nama Asesor</td>
                        <td>:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="2">Nama</td>
                        <td>:</td>
                        <td>{{ (isset($user) and !empty($user->asesi)) ? $user->asesi->name : '' }}</td>
                    </tr>
                    <tr>
                        <td colspan="2">Tanggal</td>
                        <td>:</td>
                        <td>{{ (isset($unitkompetensis) and !empty($unitkompetensis)) ? \Carbon\Carbon::parse($unitkompetensis[0]->created_at)->format('d F Y') : '' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    @if(isset($unitkompetensis) and !empty($unitkompetensis))
        @foreach($unitkompetensis as $unitkompentensi)
            <div class="form-group col-md-12">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tbody>
                        <tr>
                            <td rowspan="2" width="10%" class="text-success">Unit Kompetensi Nomor: {{ $unitkompentensi->order }}</td>
                            <td width="10%">Kode Unit</td>
                            <td width="1px">:</td>
                            <td>{{ $unitkompentensi->kode_unit_kompetensi }}</td>
                        </tr>
                        <tr>
                            <td width="10%">Judul Unit</td>
                            <td width="1px">:</td>
                            <td>{{ $unitkompentensi->title }} @if(isset($unitkompentensi->sub_title) and !empty($unitkompentensi->sub_title)) ({{ $unitkompentensi->sub_title }}) @endif</td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                @if(isset($unitkompentensi->asesisertifikasiunitkompetensielement) and !empty($unitkompentensi->asesisertifikasiunitkompetensielement))
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th width="5%">No.</th>
                                <th width="55%">Element</th>
                                <th width="10%">File</th>
                                <th width="5%">K</th>
                                <th width="5%">BK</th>
                                <th width="20%">Comment</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($unitkompentensi->asesisertifikasiunitkompetensielement as $key => $ukelement)
                            {{-- Hidden Input ID Element--}}
                            <input type="hidden" name="ukelement[id][]" value="{{ $ukelement->id }}">

                            <tr>
                                <td>{{ $key + 1 }}.</td>
                                <td>
                                    <p class="text-bold">{{ $ukelement->desc }}</p>
                                    <p>Bukti-Bukti Kompetensi:</p>
                                    <p>{!! nl2br($ukelement->upload_instruction) !!}</p>
                                </td>
                                <td>
                                    @if(isset($ukelement->media_url) and !empty($ukelement->media_url))
                                        <a href="{{ $ukelement->media_url }}">{{ $ukelement->media_url }}</a>
                                    @else
                                        {{ _('File belum di unggah') }}
                                    @endif
                                </td>
                                <td class="text-center" style="vertical-align: middle;">
                                    @if($ukelement->is_verified == true)
                                        <i class="fas fa-check"></i>
                                    @endif
                                </td>
                                <td class="text-center" style="vertical-align: middle;">
                                    @if($ukelement->is_verified == false)
                                        <i class="fas fa-check"></i>
                                    @endif
                                </td>
                                <td>
                                    {{ $ukelement->verification_note }}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        @endforeach
    @endif


</div>
@endsection

@section('js')
{{--    <script>window.print();</script>--}}
@endsection
