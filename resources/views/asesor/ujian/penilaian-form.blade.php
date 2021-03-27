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
                                <th width="90%" style="vertical-align: middle;">Pertanyaan</th>
                                <th width="5%" style="vertical-align: middle;">Score</th>
                            </tr>
                            </thead>
                            <tbody id="soal-pilihanganda-result">
                            @if(isset($isShow) OR isset($isEdit))
                                @foreach($soal_pilihangandas as $soal_pilihanganda)
                                    <tr id="pilihanganda-{{ $soal_pilihanganda->id }}">
                                        <input type="hidden" name="soal_pilihanganda_id[]" value="{{ $soal_pilihanganda->id }}">
                                        <input type="hidden" class="total-nilai" value="{{ $soal_pilihanganda->max_score }}">
                                        <input type="hidden" class="total-score" value="{{ $soal_pilihanganda->max_score }}">
                                        <td class="text-center">{{ $soal_pilihanganda->urutan }}</td>
                                        <td>
                                            <p>{{ $soal_pilihanganda->question }}</p>

                                            @if(isset($soal_pilihanganda->options_label) and !empty($soal_pilihanganda->options_label))
                                                @foreach($soal_pilihanganda->options_label as $key_pil => $pilganda)

                                                    @if($key_pil == $soal_pilihanganda->answer_option and $soal_pilihanganda->answer_option == $soal_pilihanganda->user_answer)
                                                        <span class="text-green text-bold">{{ $key_pil }}. {{ $pilganda }} <i class="fas fa-check-circle"></i></span>
                                                    @elseif($key_pil == $soal_pilihanganda->user_answer and $soal_pilihanganda->answer_option != $soal_pilihanganda->user_answer)
                                                        <span class="text-red text-bold">{{ $key_pil }}. {{ $pilganda }} <i class="fas fa-times-circle"></i></span>
                                                    @elseif($key_pil == $soal_pilihanganda->answer_option)
                                                        <span class="text-green text-bold">{{ $key_pil }}. {{ $pilganda }} <i class="fas fa-check-circle"></i></span>
                                                    @else
                                                        {{ $key_pil }}. {{ $pilganda }}
                                                    @endif

                                                    <br />

                                                @endforeach
                                            @endif
                                        </td>
                                        <td class="text-center">{{ $soal_pilihanganda->max_score }}</td>
                                    </tr>
                                @endforeach

                                <tr>
                                    <td>INFO</td>
                                    <td colspan="2">
                                        <span class="text-green text-bold"><i class="fas fa-check-circle"></i></span> = Jawaban Benar |
                                        <span class="text-red text-bold"><i class="fas fa-times-circle"></i></span> = Jawaban Salah
                                    </td>
                                </tr>
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
                                <th width="65%" style="vertical-align: middle;">Pertanyaan</th>
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
                                        <input type="hidden" class="total-score" value="{{ $soal_essay->max_score }}">
                                        <td class="text-center">{{ $soal_essay->urutan }}</td>
                                        <td>
                                            {{ $soal_essay->question }}

                                            <hr />

                                            <p class="text-bold">Jawaban Yang Benar</p>
                                            {{ $soal_essay->answer_essay }}

                                            <hr />

                                            <p class="text-bold">Jawaban Asesi</p>
                                            {{ $soal_essay->user_answer }}

                                        </td>
                                        <td class="text-center">{{ $soal_essay->max_score }}</td>
                                        <td class="text-center">
                                            @if(isset($isShow))
                                                <input type="hidden" class="form-control total-nilai" name="soal_essay[final_score][{{ $soal_essay->id }}]" value="{{ $soal_essay->final_score ?? '' }}">
                                                {{ $soal_essay->final_score }}
                                            @elseif(isset($isEdit))
                                                <input type="number" class="form-control total-nilai" name="soal_essay[final_score][{{ $soal_essay->id }}]" max="{{ $soal_essay->max_score }}" value="{{ old('soal_essay.final_score.' . $soal_essay->id, $soal_essay->final_score) }}">
                                            @endif
                                        </td>
                                        <td>
                                            @if(isset($isShow))
                                                {{ $soal_essay->catatan_asesor }}
                                            @elseif(isset($isEdit))
                                                <textarea class="form-control" name="soal_essay[catatan_asesor][{{ $soal_essay->id }}]" rows="3">{{ old('soal_essay.catatan_asesor.' . $soal_essay->id, $soal_essay->catatan_asesor) }}</textarea>
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
                        <span id="total-nilai"></span> {{ __(' / ') }}
                        <span id="total-score"></span> {{ __(' = ') }}
                        <span id="final-score-precentage">
                            @if(isset($isShow))
                                {{ $query->final_score_precentage }}
                            @endif
                        </span>{{ _('%') }}
                    </td>
                </tr>
                <tr>
                    <td width="25%">Kompeten</td>
                    <td width="2%">:</td>
                    <td>
                        @if(isset($isShow))
                            @if(isset($query->is_kompeten) and in_array($query->is_kompeten, [0, 1]))
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
                        @elseif(isset($isEdit))
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="is_kompeten" value="1" @if(isset($query->is_kompeten) and $query->is_kompeten) {{ __('checked') }} @endif>
                                <label class="form-check-label">Kompeten</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="is_kompeten" value="0" @if(isset($query->is_kompeten) and !$query->is_kompeten) {{ __('checked') }} @endif>
                                <label class="form-check-label">Tidak Kompeten</label>
                            </div>
                        @endif
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

@endsection

@section('js')
    <script>
        function sumTotal(id) {
            let sum = 0;

            // loop based on css name
            $(`.${id}`).each(function () {

                // add only if the value is number
                if (!isNaN(this.value) && this.value.length != 0) {
                    sum += parseInt(this.value);
                }
            });

            // update html
            $(`#${id}`).html(sum);

            // return value
            return sum;
        }

        function percentTotal() {
            const totalScore = sumTotal('total-score');
            const totalNilai = sumTotal('total-nilai');

            const percent = Math.ceil( ( parseInt(totalNilai) / parseInt(totalScore) ) * 100);
            $("#final-score-precentage").html(percent);
        }

        $(document).ready(function () {
            // hitung total jika ada perubahan total-score
            $(".total-score").on('change', function () {
                percentTotal();
            });
            // hitung total jika ada perubahan total-nilai
            $(".total-nilai").on('change', function () {
                percentTotal();
            });

            // run on load
            percentTotal();
        });
    </script>
@endsection
