@extends('layouts.adminlte.master')
@section('title', $title)

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

@section('body')
    <div class=""></div>
    <div class="form-row">

        <div class="form-group col-md-12">

            <div class="table-responsive mt-2 mb-2">
                <table class="table table-bordered">
                    <tbody>
                    <tr>
                        <td rowspan="3" class="text-center text-bold"  style="vertical-align: middle;">
                            Skema Sertifikasi<br/>(KKNI/Okupasi/Klaster)
                        </td>
                    </tr>
                    <tr>
                        <td>Judul</td>
                        <td>:</td>
                        <td class="text-bold">{{ (isset($sertifikasi) and !empty($sertifikasi)) ? $sertifikasi->title : '' }}</td>
                    </tr>
                    <tr>
                        <td>Nomor</td>
                        <td>:</td>
                        <td class="text-bold">{{ (isset($sertifikasi) and !empty($sertifikasi)) ? $sertifikasi->nomor_skema : '' }}</td>
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
                            <tr class="text-bold">
                                <td width="5%">
                                    Unit Kompetensi Nomor:<br/>
                                    {{ $unitkompentensi->order }}
                                </td>
                                <td width="95%" colspan="3">
                                    {{ $unitkompentensi->kode_unit_kompetensi }}<br/>
                                    {{ $unitkompentensi->title }}
                                </td>
                            </tr>
                            @if(isset($unitkompentensi->asesisertifikasiunitkompetensielement) and !empty($unitkompentensi->asesisertifikasiunitkompetensielement))
                                <tr class="text-bold">
                                    <td width="35%">@if(isset($unitkompentensi->sub_title) and !empty($unitkompentensi->sub_title)) {{ $unitkompentensi->sub_title }} @endif</td>
                                    <td width="5%" class="text-center">K</td>
                                    <td width="5%" class="text-center">BK</td>
                                    <td class="text-center">Bukti yang relevan</td>
                                </tr>

                                @foreach($unitkompentensi->asesisertifikasiunitkompetensielement as $key => $ukelement)
                                    {{-- Hidden Input ID Element--}}
                                    <input type="hidden" name="ukelement[id][]" value="{{ $ukelement->id }}">

                                    <tr>
                                        <td>
                                            <p>{!! nl2br($ukelement->desc) !!}</p>
                                        </td>
                                        <td class="text-center" style="vertical-align: middle;">
                                            <input type="checkbox" @if($ukelement->is_verified) {{__('checked')}} @endif onclick="return false;" />
                                        </td>
                                        <td class="text-center" style="vertical-align: middle;">
                                            <input type="checkbox" @if(!$ukelement->is_verified) {{__('checked')}} @endif onclick="return false;" />
                                        </td>
                                        <td>
                                            <p>{!! nl2br($ukelement->upload_instruction) !!}</p>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            @endforeach
        @endif

        <div class="form-group col-md-12">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td>
                                <p>Nama Asesi:</p>
                                <p>{{ (isset($user) and !empty($user->asesi)) ? $user->asesi->name : '' }}</p>
                            </td>
                            <td>
                                <p>Tanggal:</p>
                                <p>{{ now()->format('d-m-Y') }}</p>
                            </td>
                            <td>
                                <p>Tanda Tangan Asesi:</p>
                                <p>
                                    @if(isset($user) and !empty($user->media_url_sign_user))
                                        <img height="70px" width="70px" src="{{ (isset($user) and !empty($user->media_url_sign_user)) ? $user->media_url_sign_user : '' }}">
                                    @else
                                        {{ __('-') }}
                                    @endif
                                </p>
                            </td>
                        </tr>
                        <tr class="bg-orange text-bold">
                            <td colspan="3">Ditinjau oleh Asesor:</td>
                        </tr>
                        <tr>
                            <td>
                                <p>Nama Asesor:</p>
                                <p>{{ (isset($ujianasesiasesor) and !empty($ujianasesiasesor->userasesor) and !empty($ujianasesiasesor->userasesor->asesor)) ? $ujianasesiasesor->userasesor->asesor->name : '' }}</p>
                            </td>
                            <td>
                                <p>Rekomendasi:</p>
                                <p>{{ __('Asesmen dapat dilanjutkan/ tidak dapat dilanjutkan') }}</p>
                            </td>
                            <td>
                                <p>Tanda Tangan dan Tanggal:</p>
                                <p>{{ now()->format('d-m-Y') }}</p>
                                <p>
                                    @if(isset($ujianasesiasesor) and !empty($ujianasesiasesor->userasesor) and !empty($ujianasesiasesor->userasesor->media_url_sign_user))
                                        <img height="70px" width="70px" src="{{ (isset($ujianasesiasesor) and !empty($ujianasesiasesor->userasesor)) ? $ujianasesiasesor->userasesor->media_url_sign_user : '' }}">
                                    @else
                                        {{ __('-') }}
                                    @endif
                                </p>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <p>Diadaptasi dari template yang disediakan di Departemen Pendidikan dan Pelatihan, Australia. Merancang instrumen asesmen dalam VET. 2008</p>
            </div>
        </div>
@endsection

@section('js')
    <script>window.print();</script>
@endsection
