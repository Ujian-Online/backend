@extends('layouts.adminlte.master')
@section('title')
    {{ __('FR.MAPA.02') }} - {{ $title }}
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('print.css') }}" />
@endsection

@section('body')
    <div class="container">
        <div class="form-row">
            <h3>FR.MAPA.02. PETA INSTRUMEN ASESMEN HASIL PENDEKATAN ASESMEN DAN PERENCANAAN ASESMEN</h3>

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
                            <td class="text-bold">{{ (isset($sertifikasi) and !empty($sertifikasi)) ? $sertifikasi->title : '' }}</td>
                        </tr>
                        <tr>
                            <td>Nomor</td>
                            <td width="1%">:</td>
                            <td class="text-bold">{{ (isset($sertifikasi) and !empty($sertifikasi)) ? $sertifikasi->nomor_skema : '' }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            @if(isset($unitkompetensis) and !empty($unitkompetensis))
                <div class="form-group col-md-12">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th width="5%" class="text-center text-bold"  style="vertical-align: middle;">No.</th>
                                <th width="25%" class="text-center text-bold"  style="vertical-align: middle;">Kode Unit</th>
                                <th width="60%" class="text-center text-bold"  style="vertical-align: middle;">Judul Unit Kompetensi</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($unitkompetensis as $unitkompentensi)
                            <tr>
                                <th class="text-center text-bold"  style="vertical-align: middle;">{{ $unitkompentensi->order }}</th>
                                <td>{{ $unitkompentensi->kode_unit_kompetensi }}</td>
                                <td>{{ $unitkompentensi->title }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            <div class="form-group col-md-12">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th width="5%" rowspan="2" class="text-center text-bold"  style="vertical-align: middle;">No.</th>
                            <th width="35%" rowspan="2" class="text-center text-bold"  style="vertical-align: middle;">MUK</th>
                            <th width="50%" colspan="5" class="text-center text-bold"  style="vertical-align: middle;">Potensi Asesi</th>
                        </tr>
                        <tr>
                            <th class="text-center text-bold"  style="vertical-align: middle;">1</th>
                            <th class="text-center text-bold"  style="vertical-align: middle;">2</th>
                            <th class="text-center text-bold"  style="vertical-align: middle;">3</th>
                            <th class="text-center text-bold"  style="vertical-align: middle;">4</th>
                            <th class="text-center text-bold"  style="vertical-align: middle;">5</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(config('options.mapa_muks') as $key => $muk)
                            <tr>
                                <td class="text-center text-bold"  style="vertical-align: middle;">{{ $key+1 }}</td>
                                <td>{{ $muk }}</td>
                                <td class="text-center"><input type="checkbox" /></td>
                                <td class="text-center"><input type="checkbox" /></td>
                                <td class="text-center"><input type="checkbox" /></td>
                                <td class="text-center"><input type="checkbox" /></td>
                                <td class="text-center"><input type="checkbox" /></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>


            <p>
                *) diisi berdasarkan hasil penentuan pendekatan asesmen dan perencanaan asesmen<br />
                **) Keterangan:
                <ol>
                    <li>Hasil pelatihan dan / atau pendidikan, dimana Kurikulum dan fasilitas praktek mampu telusur terhadap standar kompetensi.</li>
                    <li>Hasil pelatihan dan / atau pendidikan, dimana kurikulum belum berbasis kompetensi.</li>
                    <li>Pekerja berpengalaman, dimana berasal dari industri/tempat kerja yang dalam operasionalnya mampu telusur dengan standar kompetensi.</li>
                    <li>Pekerja berpengalaman, dimana berasal dari industri/tempat kerja yang dalam operasionalnya belum berbasis kompetensi.</li>
                    <li>Pelatihan / belajar mandiri atau otodidak.</li>
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