@extends('layouts.adminlte.master')
@section('title')
    {{ __('FR.AK.02') }} - {{ $title }}
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('print.css') }}" />
    <style>

        img {
        display: block;
        margin-left: auto;
        margin-right: auto;
        }

    </style>
@endsection

@section('body')
    <div class="container">
        <div class="form-row">
            <h3>FR.AK.02. FORMULIR REKAMAN ASESMEN KOMPETENSI</h3>

            <div class="form-group col-md-12">
                <div class="mt-2 mb-2">
                    <table class="table table-bordered">
                        <tbody>
                        <tr>
                            <td style="vertical-align: middle;">
                                Nama Asesi
                            </td>
                            <td width="1%">:</td>
                            <td>{{ (isset($user->asesi) and !empty($user->asesi)) ? $user->asesi->name : '' }}</td>
                        </tr>
                        <tr>
                            <td style="vertical-align: middle;">
                                Nama Asesor
                            </td>
                            <td width="1%">:</td>
                            <td>{{ (isset($ujianasesiasesor->userasesor->asesor) and !empty($ujianasesiasesor->userasesor->asesor)) ? $ujianasesiasesor->userasesor->asesor->name : '' }}</td>
                        </tr>
                        <tr>
                            <td style="vertical-align: middle;">
                                Skema Sertifikasi (bila tersedia)
                            </td>
                            <td width="1%">:</td>
                            <td class="text-bold">
                                {{ (isset($sertifikasi) and !empty($sertifikasi)) ? $sertifikasi->title : '' }} <br />
                                {{ (isset($sertifikasi) and !empty($sertifikasi)) ? $sertifikasi->nomor_skema : '' }}
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align: middle;">
                                Unit kompetensi
                            </td>
                            <td width="1%">:</td>
                            <td>
                                {{ (isset($unitkompetensis) and !empty($unitkompetensis)) ? count($unitkompetensis) : '' }} unit kompetensi
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align: middle;">
                                Tanggal mulainya asesmen
                            </td>
                            <td width="1%">:</td>
                            <td>
                                {{ isset($ujianasesiasesor->order) && !empty($ujianasesiasesor->order) ? \Carbon\Carbon::parse($ujianasesiasesor->order->created_at)->format('d/m/Y') : '' }}
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align: middle;">
                                Tanggal selesainya asesmen
                            </td>
                            <td width="1%">:</td>
                            <td>
                                {{ $ujianasesiasesor->updated_at ? \Carbon\Carbon::parse($ujianasesiasesor->updated_at)->format('d/m/Y') : '' }}
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align: middle;">
                                Tanggal mulainya asesmen
                            </td>
                            <td width="1%">:</td>
                            <td>
                                {{ isset($ujianasesiasesor->order->tuk) && !empty($ujianasesiasesor->order->tuk) ? $ujianasesiasesor->order->tuk->title : '' }}
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <p>Beri tanda centang (√) di kolom yang sesuai untuk mencerminkan bukti yang diperoleh untuk menentukan Kompetensi asesi untuk setiap Unit Kompetensi.</p>
            </div>

            <div class="form-group col-md-12">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center">Unit kompetensi (kode UK)</th>
                                <th>Observasi demonstrasi</th>
                                <th>Portofolio</th>
                                <th>Pernyataan Pihak Ketiga Pertanyaan Wawancara</th>
                                <th>Pertanyaan lisan</th>
                                <th>Pertanyaan tertulis</th>
                                <th>Proyek kerja</th>
                                <th>Lainnya</th>
                            </tr>
                        </thead>
                        <tbody>
                        @if(isset($unitkompetensis) and !empty($unitkompetensis))
                            @foreach($unitkompetensis as $unitkompentensi)
                                <tr>
                                    <td class="text-center">
                                        {{ $unitkompentensi->kode_unit_kompetensi }}<br />
                                        {{ $unitkompentensi->asesisertifikasiunitkompetensielement ? count($unitkompentensi->asesisertifikasiunitkompetensielement) : '' }}
                                    </td>
                                    <td><textarea rows="1" style="width: 100%; text-align: center;"></textarea></td>
                                    <!-- Add Text Area -->
                                    <td><textarea rows="1" style="width: 100%; text-align: center;"></textarea></td>
                                    <td><textarea rows="1" style="width: 100%; text-align: center;"></textarea></td>
                                    <td><textarea rows="1" style="width: 100%; text-align: center;"></textarea></td>
                                    <td><textarea rows="1" style="width: 100%; text-align: center;"></textarea></td>
                                    <td><textarea rows="1" style="width: 100%; text-align: center;"></textarea></td>
                                    <td><textarea rows="1" style="width: 100%; text-align: center;"></textarea></td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="2" class="bg-yellow">Rekomendasi hasil asesmen</td>
                                <td colspan="7" class="bg-yellow">
                                    <p><input type="radio" name="rekomendasi"> Kompeten</p>
                                    <p><input type="radio" name="rekomendasi"> Belum Kompeten</p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    Tindak lanjut yang dibutuhkan <br />
                                    <p><textarea rows="3" style="width: 100%; text-align: left;"></textarea></p>

                                </td>
                                <td colspan="7">
                                    <p><input type="radio" name="tindakan"> Tidak ada</p>
                                    <p><input type="radio" name="tindakan"> Tindak lanjut yang dibutuhkan :</p>
                                    <textarea rows="3" style="width: 100%; text-align: left;"></textarea>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    Komentar/ Observasi oleh asesor
                                    <p><textarea rows="2" style="width: 100%; text-align: left; border: 0;"></textarea></p>
                                </td>
                                <td colspan="7">
                                    <p><input type="radio" name="komentar"> Tidak ada</p>
                                    <p><input type="radio" name="komentar"> Komentar :</p>
                                    <textarea rows="3" style="width: 100%; text-align: left;"></textarea>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="1">Tanda tangan asesi:</td>
                                <td colspan="4">
                                    @if(isset($user) and !empty($user->media_url_sign_user))
                                        <img class="center" height="70px" width="70px" src="{{ (isset($user) and !empty($user->media_url_sign_user)) ? $user->media_url_sign_user : '' }}">
                                    @else
                                        {{ __('-') }}
                                    @endif
                                </td>
                                <td colspan="1">Tanggal:</td>
                                <td colspan="3">{{ $ujianasesiasesor->updated_at ? \Carbon\Carbon::parse($ujianasesiasesor->updated_at)->format('d/m/Y') : '' }}</td>
                            </tr>
                            <tr>
                                <td colspan="1">Tanda tangan asesor:</td>
                                <td colspan="4">
                                    @if(isset($ujianasesiasesor) and !empty($ujianasesiasesor->userasesor) and !empty($ujianasesiasesor->userasesor->media_url_sign_user))
                                        <img class="center" height="70px" width="70px" src="{{ (isset($ujianasesiasesor) and !empty($ujianasesiasesor->userasesor)) ? $ujianasesiasesor->userasesor->media_url_sign_user : '' }}">
                                    @else
                                        {{ __('-') }}
                                    @endif
                                </td>
                                <td colspan="1">Tanggal:</td>
                                <td colspan="3">{{ $ujianasesiasesor->updated_at ? \Carbon\Carbon::parse($ujianasesiasesor->updated_at)->format('d/m/Y') : '' }}</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>

            <p>LAMPIRAN DOKUMEN:</p>
            <p>
                <ol>
                    <li>Dokumen APL 01 peserta</li>
                    <li>Dokumen APL 02 peserta</li>
                </ol>
            </p>

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
