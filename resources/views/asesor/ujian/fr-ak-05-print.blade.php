@extends('layouts.adminlte.master')
@section('title')
    {{ __('FR.AK.05') }} - {{ $title }}
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('print.css') }}" />
@endsection

@section('body')
    <div class="container">
        <div class="form-row">
            <h3>FR.AK.05. LAPORAN ASESMEN</h3>

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
                            Tanggal
                        </td>
                        <td width="1%">:</td>
                        <td>{{ (isset($query->ujianjadwal) and !empty($query->ujianjadwal)) ? \Carbon\Carbon::parse($query->ujianjadwal->tanggal)->format('d-m-Y') : '' }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <div class="table-responsive mt-2 mb-2">
                <table border="1px" class="table table-bordered">
                    <thead>
                        <tr>
                            <th rowspan="2" width="1%" class="text-center" style="vertical-align: middle;">No.</th>
                            <th rowspan="2" width="44%" class="text-center" style="vertical-align: middle;">Nama Asesi</th>
                            <th colspan="2" width="10%" class="text-center" style="vertical-align: middle;">Rekomendasi</th>
                            <th rowspan="2" width="44%" class="text-center" style="vertical-align: middle;">Keterangan**</th>
                        </tr>
                        <tr>
                            <th class="text-center" width="5%" style="vertical-align: middle;">K</th>
                            <th class="text-center" width="5%" style="vertical-align: middle;">BK</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center">1.</td>
                            <td>
                                {{ (isset($query->userasesi->asesi) and !empty($query->userasesi->asesi)) ? $query->userasesi->asesi->name : '' }}
                            </td>
                            <td class="text-center">
                                <input type="checkbox" @if($query->is_kompeten && $query->is_kompeten === true) {{__('checked')}} @endif onclick="return false;" />
                            </td>
                            <td class="text-center">
                                <input type="checkbox" @if($query->is_kompeten && $query->is_kompeten === false) {{__('checked')}} @endif onclick="return false;" />
                            </td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <p>** tuliskan Kode dan Judul Unit Kompetensi yang dinyatakan BK bila mengases satu skema</p>

            <div class="table-responsive mt-2 mb-2">
                <table border="1px" class="table table-bordered">
                    <tbody>
                        <tr>
                            <td width="50%">Aspek Negatif dan Positif dalam Asesemen</td>
                            <td width="50%">
                                <textarea rows="3" style="width: 100%; "></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td width="50%">Pencatatan Penolakan Hasil Asesmen</td>
                            <td width="50%">
                                <textarea rows="3" style="width: 100%; "></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td width="50%">Saran Perbaikan :<br />(Asesor/Personil Terkait)</td>
                            <td width="50%">
                                <textarea rows="3" style="width: 100%; "></textarea>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="table-responsive mt-2 mb-2">
                <table border="1px" class="table table-bordered">
                    <tbody>
                    <tr>
                        <td rowspan="4" width="50%">
                            <span class="text-bold">Catatan:</span>
                        </td>
                        <td colspan="2" width="50%">
                            <span class="text-bold">Asesor:</span>
                        </td>
                    </tr>
                    <tr>
                        <td width="15%">Nama</td>
                        <td width="35%">{{ (isset($query->userasesor->asesor) and !empty($query->userasesor->asesor)) ? $query->userasesor->asesor->name : '' }}</td>
                    </tr>
                    <tr>
                        <td width="15%">No. Reg</td>
                        <td width="35%">{{ (isset($query->userasesor->asesor) and !empty($query->userasesor->asesor)) ? $query->userasesor->asesor->met : '' }}</td>
                    </tr>
                    <tr>
                        <td width="15%">
                            Tanda tangan/<br />Tanggal
                        </td>
                        <td width="35%">
                            @if(isset($query->userasesor) and !empty($query->userasesor) and !empty($query->userasesor->media_url_sign_user))
                                <img height="70px" width="70px" src="{{ $query->userasesor->media_url_sign_user }}">
                            @else
                                {{ ('-') }}<br /><br /> {{ now()->format('d/m/Y') }}
                            @endif
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
