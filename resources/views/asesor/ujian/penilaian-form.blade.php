@extends('layouts.pageForm')

@section('form')
    @include('layouts.alert')

    <div class="form-row">
        <div class="table-responsive mt-2 mb-2">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td rowspan="3" class="text-center text-bold"  style="vertical-align: middle;">
                            Detail Asesi
                        </td>
                    </tr>
                    <tr>
                        <td width="15%">Nama</td>
                        <td width="2%">:</td>
                        <td class="text-bold">{{ (isset($query->userasesi->asesi) and !empty($query->userasesi->asesi)) ? $query->userasesi->asesi->name : '' }}</td>
                    </tr>
                    <tr>
                        <td width="15%">Email</td>
                        <td width="2%">:</td>
                        <td>{{ $query->userasesi->email }}</td>
                    </tr>
                    <tr>
                        <td rowspan="3" class="text-center text-bold"  style="vertical-align: middle;">
                            Detail Asesor
                        </td>
                    </tr>
                    <tr>
                        <td width="15%">Nama</td>
                        <td width="2%">:</td>
                        <td class="text-bold">{{ (isset($query->userasesor->asesor) and !empty($query->userasesor->asesor)) ? $query->userasesor->asesor->name : '' }}</td>
                    </tr>
                    <tr>
                        <td width="15%">MET</td>
                        <td width="2%">:</td>
                        <td>{{ (isset($query->userasesor->asesor) and !empty($query->userasesor->asesor)) ? $query->userasesor->asesor->met : '' }}</td>
                    </tr>
                    <tr>
                        <td rowspan="3" class="text-center text-bold"  style="vertical-align: middle;">
                            Skema Sertifikasi
                        </td>
                    </tr>
                    <tr>
                        <td width="15%">Nomor</td>
                        <td width="2%">:</td>
                        <td>{{ (isset($query->sertifikasi) and !empty($query->sertifikasi)) ? $query->sertifikasi->nomor_skema : '' }}</td>
                    </tr>
                    <tr>
                        <td width="15%">Judul</td>
                        <td width="2%">:</td>
                        <td class="text-bold">{{ (isset($query->sertifikasi) and !empty($query->sertifikasi)) ? $query->sertifikasi->title : '' }}</td>
                    </tr>
                    <tr>
                        <td rowspan="5" class="text-center text-bold"  style="vertical-align: middle;">
                            Detail Ujian
                        </td>
                    </tr>
                    <tr>
                        <td width="15%">Paket Soal</td>
                        <td width="2%">:</td>
                        <td>{{ (isset($query->soalpaket) and !empty($query->soalpaket)) ? $query->soalpaket->title : '' }}
                        </td>
                    </tr>
                    <tr>
                        <td width="15%">Tanggal Ujian</td>
                        <td width="2%">:</td>
                        <td>{{ (isset($query->ujianjadwal) and !empty($query->ujianjadwal)) ? \Carbon\Carbon::parse($query->ujianjadwal->tanggal)->format('d/m/Y') : '' }}</td>
                    </tr>
                    <tr>
                        <td width="15%">Judul Ujian</td>
                        <td width="2%">:</td>
                        <td>{{ (isset($query->ujianjadwal) and !empty($query->ujianjadwal)) ? $query->ujianjadwal->title : '' }}</td>
                    </tr>
                    <tr>
                        <td width="15%">Deskripsi Ujian</td>
                        <td width="2%">:</td>
                        <td>{{ (isset($query->ujianjadwal) and !empty($query->ujianjadwal)) ? $query->ujianjadwal->description : '' }}</td>
                    </tr>
                    <tr>
                        <td rowspan="3" class="text-center text-bold"  style="vertical-align: middle;">
                            Detail TUK
                        </td>
                    </tr>
                    <tr>
                        <td width="15%">Nama</td>
                        <td width="2%">:</td>
                        <td class="text-bold">{{ (isset($query->order->tuk) and !empty($query->order->tuk)) ? $query->order->tuk->title : '' }}</td>
                    </tr>
                    <tr>
                        <td width="15%">Type</td>
                        <td width="2%">:</td>
                        <td>
                            @php
                                // untuk hitung loop buat strip (/)
                                $countKey = 0;
                                $tuk = $query->order->tuk ?? '';
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
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-tasks"></i> Soal Pilihan Ganda</h3>
        </div>
        <div class="card-body">
            <div class="form-row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr class="text-center">
                                <th width="5%" style="vertical-align: middle;">ID</th>
                                <th width="50%" style="vertical-align: middle;">Pertanyaan</th>
                                <th width="20%" style="vertical-align: middle;">Jawaban Asesi</th>
                                <th width="20%" style="vertical-align: middle;">Jawaban Benar</th>
                                <th width="5%" style="vertical-align: middle;">Score</th>
                            </tr>
                            </thead>
                            <tbody id="soal-pilihanganda-result">
                            @if(isset($isShow) OR isset($isEdit))
                                @foreach($soal_pilihangandas as $soal_pilihanganda)
                                    <tr id="pilihanganda-{{ $soal_pilihanganda->id }}">
                                        <input type="hidden" name="soal_pilihanganda_id[]" value="{{ $soal_pilihanganda->id }}">
                                        <td class="text-center">{{ $soal_pilihanganda->urutan }}</td>
                                        <td>
                                            <p>{{ $soal_pilihanganda->question }}</p>

                                            @if(isset($soal_pilihanganda->options_label) and !empty($soal_pilihanganda->options_label))
                                                @foreach($soal_pilihanganda->options_label as $key_pil => $pilganda)

                                                    @if($key_pil == $soal_pilihanganda->answer_option)
                                                        <span class="text-bold">{{ $key_pil }}. {{ $pilganda }}</span>
                                                    @else
                                                        {{ $key_pil }}. {{ $pilganda }}
                                                    @endif

                                                    <br />

                                                @endforeach
                                            @endif
                                        </td>
                                        <td>{{ $soal_pilihanganda->user_answer ? $soal_pilihanganda->options_label[$soal_pilihanganda->user_answer] : '' }}</td>
                                        <td>{{ $soal_pilihanganda->answer_option ? $soal_pilihanganda->answer_option . '. ' .$soal_pilihanganda->options_label[$soal_pilihanganda->answer_option] : '' }}</td>
{{--                                        <td class="text-center">{{ $soal_pilihanganda->user_answer }}</td>--}}
{{--                                        <td class="text-center">{{ $soal_pilihanganda->answer_option }}</td>--}}
                                        <td class="text-center">{{ $soal_pilihanganda->max_score }}</td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card card-outline card-info">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-tasks"></i> Soal Essay</h3>
        </div>
        <div class="card-body">
            <div class="form-row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr class="text-center">
                                <th width="5%" style="vertical-align: middle;">ID</th>
                                <th width="25%" style="vertical-align: middle;">Pertanyaan</th>
                                <th width="20%" style="vertical-align: middle;">Jawaban Asesi</th>
                                <th width="20%" style="vertical-align: middle;">Jawaban Benar</th>
                                <th width="5%" style="vertical-align: middle;">Max Score</th>
                                <th width="10%" style="vertical-align: middle;">Final Score</th>
                                <th width="15%" style="vertical-align: middle;">Catatan Asesor</th>
                            </tr>
                            </thead>
                            <tbody id="soal-essay-result">
                            @if(isset($isShow) OR isset($isEdit))
                                @foreach($soal_essays as $soal_essay)
                                    <tr id="essay-{{ $soal_essay->id }}">
                                        <input type="hidden" name="soal_essay_id[]" value="{{ $soal_essay->id }}">
                                        <td class="text-center">{{ $soal_essay->urutan }}</td>
                                        <td>{{ $soal_essay->question }}</td>
                                        <td>{{ $soal_essay->user_answer }}</td>
                                        <td>{{ $soal_essay->answer_essay }}</td>
                                        <td class="text-center">{{ $soal_essay->max_score }}</td>
                                        <td class="text-center">
                                            @if(isset($isShow))
                                                {{ $soal_essay->final_score }}
                                            @elseif(isset($isEdit))
                                                <input type="number" class="form-control" name="soal_essay[final_score][{{ $soal_essay->id }}]" value="{{ $soal_essay->final_score ?? '' }}">
                                            @endif
                                        </td>
                                        <td>
                                            @if(isset($isShow))
                                                {{ $soal_essay->catatan_asesor }}
                                            @elseif(isset($isEdit))
                                                <textarea class="form-control" name="soal_essay[catatan_asesor][{{ $soal_essay->id }}]" rows="3">{{ $soal_essay->catatan_asesor }}</textarea>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(isset($isShow))
    <div class="form-row">
        <div class="table-responsive mt-2 mb-2">
            <table class="table table-bordered">
                <tbody>
                <tr>
                    <td rowspan="3" class="text-center text-bold"  style="vertical-align: middle;">
                        Hasil Akhir
                    </td>
                </tr>
                <tr>
                    <td width="25%">Score Ujian Hasil/Max</td>
                    <td width="2%">:</td>
                    <td class="text-bold">
                        {{ $total_nilai }} / {{ $total_max }}
                        @if(!empty($query->final_score_percentage))
                            {{ _('=') }} {{ $query->final_score_percentage }}{{ _('%') }}
                        @endif
                    </td>
                </tr>
                <tr>
                    <td width="25%">Kompeten</td>
                    <td width="2%">:</td>
                    <td>
                        @if(!empty($query->is_kompeten))
                            @if($query->is_kompeten)
                                <span>Kompeten</span>{{ _(' / ') }}
                                <span style="text-decoration: line-through;">Tidak Kompeten</span>
                            @else
                                <span style="text-decoration: line-through;">Kompeten</span>{{ _(' / ') }}
                                <span>Tidak Kompeten</span>
                            @endif
                        @else
                            <span>Kompeten</span>{{ _(' / ') }}
                            <span>Tidak Kompeten</span>
                        @endif
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    @endif

@endsection
