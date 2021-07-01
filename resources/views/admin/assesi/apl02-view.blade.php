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

            @if(isset($isShow))
                <button type="button" class="btn btn-success m-2" onclick="window.open('{{ request()->url() }}?print=true', '', 'fullscreen=yes');">
                    <i class="fas fa-print"></i> Cetak FR.APL.02</a>
                </button>
                <button type="button" class="btn btn-success m-2" onclick="window.open('{{ request()->url() }}?print=true&page=mapa02', '', 'fullscreen=yes');">
                    <i class="fas fa-print"></i> Cetak FR.MAPA.02</a>
                </button>
            @endif

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
                        <td>:</td>
                        <td class="bg-success">{{ (isset($sertifikasi) and !empty($sertifikasi)) ? $sertifikasi->title : '' }}</td>
                    </tr>
                    <tr>
                        <td>Nomor</td>
                        <td>:</td>
                        <td>{{ (isset($sertifikasi) and !empty($sertifikasi)) ? $sertifikasi->nomor_skema : '' }}</td>
                    </tr>
{{--                    @if(isset($tuk) and !empty($tuk))--}}
{{--                        <tr>--}}
{{--                            <td colspan="2">TUK</td>--}}
{{--                            <td>:</td>--}}
{{--                            <td>--}}

{{--                                @php--}}
{{--                                    // untuk hitung loop buat strip (/)--}}
{{--                                    $countKey = 0;--}}
{{--                                @endphp--}}
{{--                                @foreach(config('options.tuk_type') as $keyTukType => $tukType)--}}

{{--                                    @if($countKey > 0 )--}}
{{--                                        {{ __('/') }}--}}
{{--                                    @endif--}}
{{--                                    @if($keyTukType == $tuk->type)--}}
{{--                                        {{ $tukType }}--}}
{{--                                    @else--}}
{{--                                        <span style="text-decoration: line-through;">{{ $tukType }}</span>--}}
{{--                                    @endif--}}

{{--                                    @php--}}
{{--                                        $countKey = $countKey+1--}}
{{--                                    @endphp--}}
{{--                                @endforeach--}}

{{--                            </td>--}}
{{--                        </tr>--}}
{{--                    @endif--}}
                    {{--<tr>--}}
                    {{--<td colspan="2">Nama Asesor</td>--}}
                    {{--<td>:</td>--}}
                    {{--<td></td>--}}
                    {{--</tr>--}}
{{--                    <tr>--}}
{{--                        <td colspan="2">Nama</td>--}}
{{--                        <td>:</td>--}}
{{--                        <td>{{ (isset($user) and !empty($user->asesi)) ? $user->asesi->name : '' }}</td>--}}
{{--                    </tr>--}}
{{--                    @if(isset($order) and !empty($order))--}}
{{--                        <tr>--}}
{{--                            <td colspan="2">Tanggal</td>--}}
{{--                            <td>:</td>--}}
{{--                            <td>{{ (isset($order) and !empty($order)) ? \Carbon\Carbon::parse($order->created_at)->format('d F Y') : '' }}</td>--}}
{{--                        </tr>--}}
{{--                    @endif--}}
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
                                <td rowspan="2" width="10%" class="bg-success">Unit Kompetensi Nomor: {{ $unitkompentensi->order }}</td>
                                <td width="10%">Kode Unit</td>
                                <td width="1px">:</td>
                                <td>{{ $unitkompentensi->kode_unit_kompetensi }}</td>
                            </tr>
                            <tr>
                                <td width="10%">Judul Unit</td>
                                <td width="1px">:</td>
                                <td>{{ $unitkompentensi->title }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                    @if(isset($unitkompentensi->asesisertifikasiunitkompetensielement) and !empty($unitkompentensi->asesisertifikasiunitkompetensielement))
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th width="5%" class="text-center" style="vertical-align: middle;">No.</th>
                                <th width="35%" class="text-center" style="vertical-align: middle;">@if(isset($unitkompentensi->sub_title) and !empty($unitkompentensi->sub_title)) {{ $unitkompentensi->sub_title }} @endif</th>
                                <td width="5%" class="text-center">K</td>
                                <td width="5%" class="text-center">BK</td>
                                <th width="25%" class="text-center" style="vertical-align: middle;">Bukti yang relevan</th>
                                <th width="25%" class="text-center" style="vertical-align: middle;">Comment</th>
                            </tr>
                            </thead>
                            <tbody>

                            @php
                                // untuk buat nomor media id
                                $mediaKeyID = 0;
                            @endphp

                            @foreach($unitkompentensi->asesisertifikasiunitkompetensielement as $key => $ukelement)
                                {{-- Hidden Input ID Element--}}
                                <input type="hidden" name="ukelement[id][]" value="{{ $ukelement->id }}">

                                <tr>
                                    <td>{{ $key + 1 }}.</td>
                                    <td>
                                        <p class="text-bold">{!! nl2br($ukelement->desc) !!}</p>
                                        <p>{!! nl2br($ukelement->upload_instruction) !!}</p>
                                    </td>
                                    <td class="text-center">
                                        @if(isset($isShow))
                                            <input type="checkbox" name="ukelement[is_verified][{{$ukelement->id}}]" id="ukelement-is_verified-{{$ukelement->id}}" @if($ukelement->is_verified) {{__('checked')}} @endif onclick="return false;" />
                                        @else
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="ukelement[is_verified][{{$ukelement->id}}]"
                                                       id="ukelement-is_verified-{{$ukelement->id}}" value="1" @if($ukelement->is_verified == 1) {{ __('checked') }} @endif>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if(isset($isShow))
                                            <input type="checkbox" name="ukelement[is_verified][{{$ukelement->id}}]" id="ukelement-is_verified-{{$ukelement->id}}" @if(!$ukelement->is_verified) {{__('checked')}} @endif onclick="return false;" />
                                        @else
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="ukelement[is_verified][{{$ukelement->id}}]"
                                                       id="ukelement-is_verified-{{$ukelement->id}}" value="0" @if($ukelement->is_verified == 0) {{ __('checked') }} @endif>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        @if(count($ukelement->media) != 0)
                                            @foreach($ukelement->media as $keymedia => $media)

                                                @php
                                                    // untuk buat nomor media id
                                                    $mediaKeyID = $mediaKeyID+1
                                                @endphp

                                                <p>
                                                    {{ $unitkompentensi->order }}.{{$mediaKeyID}}. {{ucfirst($media->description)}}
                                                    <button type="button" onclick="window.open('{{ $media->media_url }}', '', 'fullscreen=yes');"  class="btn btn-sm btn-primary btn-block">Buka File</button>
                                                </p>

                                            @endforeach
                                        @else
                                            {{ __('File belum di unggah') }}
                                        @endif
                                    </td>
                                    <td>
                                        @if(isset($isShow))
                                            {{ $ukelement->verification_note }}
                                        @elseif(isset($isEdit))
                                            <textarea class="form-control" rows="5"
                                                      name="ukelement[verification_note][{{$ukelement->id}}]"
                                                      id="ukelement-verification_note-{{$ukelement->id}}">{{ $ukelement->verification_note }}</textarea>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            @endforeach
        @endif


        <h2>Penilaian Assesor</h2>

        <div class="form-group col-md-12">
            <label for="recommendation">Rekomendasi</label>
            <textarea
                rows="3"
                class="form-control @error('recommendation') is-invalid @enderror"
                name="recommendation" id="recommendation" @if(isset($isShow)) readonly @endif>{{ old('recommendation') ?? $apl02_verification->recommendation ?? '' }}</textarea>

            @error('recommendation')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group col-md-6">
            <label for="jenis_pengalaman">Jenis Pengalaman</label>
            <select name="jenis_pengalaman" id="jenis_pengalaman" class="form-control">
                <option value="1" @if($apl02_verification && $apl02_verification->jenis_pengalaman) {{__('selected')}} @endif>Berpengalaman</option>
                <option value="0" @if(!$apl02_verification  XOR $apl02_verification && !$apl02_verification->jenis_pengalaman) {{__('selected')}} @endif>Belum Berpengalaman</option>
            </select>

            @error('jenis_pengalaman')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group col-md-6">
            <label for="asesor_verification_date">Tanggal Verifikasi</label>
            <div class="input-group date" id="datetimepicker2" data-target-input="nearest">
                <input type="text" class="form-control datetimepicker-input @error('asesor_verification_date') is-invalid @enderror"
                       data-target="#datetimepicker2" name="asesor_verification_date" id="asesor_verification_date" placeholder="Tanggal"
                       value="{{ isset($apl02_verification) ? \Carbon\Carbon::parse($apl02_verification->asesor_verification_date)->format('d/m/Y') : now()->format('d/m/Y') }}"
                       @if(isset($isShow)) disabled @endif>
                <div class="input-group-append" data-target="#datetimepicker2" data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                </div>
            </div>

            @error('asesor_verification_date')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

    </div>
@endsection

@section('js')
    <script>
        {{--$(document).on('keydown', function(e) {--}}
        {{--    e.preventDefault();--}}

        {{--    if((e.ctrlKey || e.metaKey) && (e.key == "p" || e.charCode == 16 || e.charCode == 112 || e.keyCode == 80) ){--}}
        {{--        e.cancelBubble = true;--}}
        {{--        e.stopImmediatePropagation();--}}

        {{--        const redirectPrint = '{{ request()->url() }}?print=true';--}}
        {{--        window.location = redirectPrint;--}}
        {{--    }--}}
        {{--});--}}


        $('select').select2({
            theme: 'bootstrap4',
            disabled: {{ (isset($isShow) and !empty($isShow)) ? 'true' : 'false' }}
        });

        $('#datetimepicker2').datetimepicker({
            useCurrent: false,
            format: 'DD/MM/YYYY',
            locale: 'id'
        });
    </script>
@endsection
