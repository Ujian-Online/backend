@extends('layouts.pageForm')

@section('form')
    @include('layouts.alert')

    <div class="form-row">

        <div class="form-group col-md-12">

            <a href="{{ request()->url() }}?print=true" class="btn btn-success"><i class="fas fa-print"></i> Cetak APL-02</a>

            <div class="table-responsive mt-2 mb-2">
                <table class="table table-bordered">
                    <tbody>
                    <tr>
                        <td rowspan="3" class="text-center text-bold bg-success"  style="vertical-align: middle;">
                            Skema Sertifikasi
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
                    @if(isset($tuk) and !empty($tuk))
                    <tr>
                        <td colspan="2">TUK</td>
                        <td>:</td>
                        <td>

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

                        </td>
                    </tr>
                    @endif
                    {{--<tr>--}}
                    {{--<td colspan="2">Nama Asesor</td>--}}
                    {{--<td>:</td>--}}
                    {{--<td></td>--}}
                    {{--</tr>--}}
                    <tr>
                        <td colspan="2">Nama</td>
                        <td>:</td>
                        <td>{{ (isset($user) and !empty($user->asesi)) ? $user->asesi->name : '' }}</td>
                    </tr>
                    @if(isset($order) and !empty($order))
                        <tr>
                            <td colspan="2">Tanggal</td>
                            <td>:</td>
                            <td>{{ (isset($order) and !empty($order)) ? \Carbon\Carbon::parse($order->created_at)->format('d F Y') : '' }}</td>
                        </tr>
                    @endif
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
                                <td>{{ $unitkompentensi->title }} @if(isset($unitkompentensi->sub_title) and !empty($unitkompentensi->sub_title)) ({{ $unitkompentensi->sub_title }}) @endif</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                @if(isset($unitkompentensi->asesisertifikasiunitkompetensielement) and !empty($unitkompentensi->asesisertifikasiunitkompetensielement))
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th width="5%" class="text-center" style="vertical-align: middle;">No.</th>
                                <th width="60%" class="text-center" style="vertical-align: middle;">Element</th>
                                <th width="10%" class="text-center" style="vertical-align: middle;">File</th>
                                <th width="5%" class="text-center" style="vertical-align: middle;">Verify (K/BK)</th>
                                <th width="20%" class="text-center" style="vertical-align: middle;">Comment</th>
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
                                            <a class="btn btn-sm btn-primary btn-block" href="{{ $ukelement->media_url }}">Buka File</a>
                                        @else
                                            {{ _('File belum di unggah') }}
                                        @endif
                                    </td>
                                    <td>
                                        @if(isset($isShow))
                                            {{ $ukelement->is_verified ? 'YES' : 'NO' }}
                                        @elseif(isset($isEdit))
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="ukelement[is_verified][{{$ukelement->id}}]"
                                                       id="ukelement-is_verified-{{$ukelement->id}}" value="1" @if($ukelement->is_verified == 1) {{ _('checked') }} @endif>
                                                <label class="form-check-label">YES</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="ukelement[is_verified][{{$ukelement->id}}]"
                                                       id="ukelement-is_verified-{{$ukelement->id}}" value="0" @if($ukelement->is_verified == 0) {{ _('checked') }} @endif>
                                                <label class="form-check-label">NO</label>
                                            </div>
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


    </div>
@endsection

@section('js')
    <script>
        $(document).on('keydown', function(e) {
            e.preventDefault();

            if((e.ctrlKey || e.metaKey) && (e.key == "p" || e.charCode == 16 || e.charCode == 112 || e.keyCode == 80) ){
                e.cancelBubble = true;
                e.stopImmediatePropagation();

                const redirectPrint = '{{ request()->url() }}?print=true';
                window.location = redirectPrint;
            }
        });


        $('select').select2({
            theme: 'bootstrap4',
            disabled: {{ (isset($isShow) and !empty($isShow)) ? 'true' : 'false' }}
        });
    </script>
@endsection
